<?php

namespace backend\controllers;

use backend\models\SnippetCode;
use Exception;
use Yii;
use backend\models\Model;
use backend\models\Snippet;
use backend\models\search\SnippetSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;
use backend\models\SnippetVar;

/**
 * SnippetController implements the CRUD actions for Snippet model.
 */
class SnippetController extends BaseController
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Snippet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SnippetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Snippet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Snippet();
        $modelsSnippetCode = [new SnippetCode()];
        //$modelsSnippetVar = [new SnippetVar()];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             $modelsSnippetCode = [];

            //TODO - !!! this is hardcoded! as in above create action - should be refactored.
            $snippetCodeData = Yii::$app->request->post('SnippetCode');
            $oldCodesIDs = ArrayHelper::map($model->snippetCodes, 'id', 'id');
            foreach ($snippetCodeData as $codeData) {
                if (isset($codeData['name'])) {
                    $snippetCode = new SnippetCode();

                    $snippetCode->name = $codeData['name'];
                    $snippetCode->code = $codeData['code'];
                    $snippetCode->popis = $codeData['popis'];
                    $snippetCode->portal = $codeData['portal'];

                    $modelsSnippetCode[] = $snippetCode;
                }
            }
            $newCodesIDs = ArrayHelper::map($modelsSnippetCode, 'id', 'id');
            $codesIDsToDelete = array_diff($oldCodesIDs, $newCodesIDs);

            $modelsSnippetVar = [];

            $snippetVarData = Yii::$app->request->post('SnippetVar');
            if ($snippetVarData > 0) {
                foreach ($snippetVarData as $varData) {
                    if (isset($varData['identifier']) && $varData['identifier']) {
                        if (isset($varData['id']) && $varData['id']) {
                            $snippetVar = SnippetVar::findOne($varData['id']);
                            $snippetVar->id = $varData['id'];
                        } else {
                            $snippetVar = new SnippetVar();
                        }
                        
                        $snippetVar->identifier = $varData['identifier'];
                        $snippetVar->type_id = $varData['type_id'];
                        $snippetVar->default_value = $varData['default_value'];
                        $snippetVar->description = $varData['description'];
                        $snippetVar->tmp_id = $varData['tmp_id'];

                        if (isset($varData['parent_id'])) {
                            $snippetVar->parent_id = $varData['parent_id'];
                            
                            // TODO should go to beforesave - in model
                            if (!$snippetVar->parent_id) {
                                $snippetVar->parent_id = null;
                            }
                        }
                        
                        $modelsSnippetVar[] = $snippetVar;
                    }
                }
            }

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                                ActiveForm::validateMultiple($modelsSnippetCode), ActiveForm::validateMultiple($modelsSnippetVar), ActiveForm::validate($model)
                );
            }
            
            // validate all models
            $valid = $model->validate() && 
                    Model::validateMultiple($modelsSnippetCode) &&
                    Model::validateMultiple($modelsSnippetVar);

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsSnippetCode as $modelSnippetCode) {
                            $modelSnippetCode->link('snippet', $model);

                            //TODO here will be code for change portals.
                            // Update snippet portals (alternatives of snippet).
//                            $portals_array = Yii::$app->request->post('snippet_code_portals');
//                            $portals_ids = !$portals_array ? : implode($portals_array, ',');
//                            $modelSnippetCode->portal = $portals_ids;

                            if (!($flag = $modelSnippetCode->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsSnippetVar as $var) {
                            $var->snippet_id = $model->id;
                            $flag = $var->save(false);

                            if (!($flag)) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        
                        // Parent ids change back to id of parent.
                        foreach ($modelsSnippetVar as $savedVar) {
                            $parent = SnippetVar::find()
                                    ->where(['tmp_id' => $savedVar->parent_id])
                                    ->andWhere(['not', ['tmp_id' => null]])
                                    ->one(); 
                                if ($parent) {
                                    $savedVar->parent_id = strval($parent->id);
                                    $savedVar->save();
                                }
                            
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['index']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'modelsSnippetCode' => (empty($modelsSnippetCode)) ? [new SnippetCode()] : $modelsSnippetCode,
            ]);
        }
    }

    /**
     * Updates an existing Snippet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {       
        $model = $this->findModel($id);
        $modelsSnippetCode = $model->snippetCodes;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
      
            $modelsSnippetCode = [];

            //TODO - !!! this is hardcoded! as in above create action - should be refactored.
            $snippetCodeData = Yii::$app->request->post('SnippetCode');
            $oldCodesIDs = ArrayHelper::map($model->snippetCodes, 'id', 'id');
            foreach ($snippetCodeData as $codeData) {
                if (isset($codeData['name'])) {
                    $snippetCode = SnippetCode::findOne($codeData['id']) ? : new SnippetCode();

                    $snippetCode->name = $codeData['name'];
                    $snippetCode->code = $codeData['code'];
                    $snippetCode->popis = $codeData['popis'];
                    $snippetCode->portal = $codeData['portal'];

                    $modelsSnippetCode[] = $snippetCode;
                }
            }
            $newCodesIDs = ArrayHelper::map($modelsSnippetCode, 'id', 'id');
            $codesIDsToDelete = array_diff($oldCodesIDs, $newCodesIDs);

            $modelsSnippetVar = [];

            $snippetVarData = Yii::$app->request->post('SnippetVar');
            if ($snippetVarData > 0) {
                foreach ($snippetVarData as $varData) {
                    //if (isset($varData['identifier']) && $varData['identifier']) {
                        if (isset($varData['id']) && $varData['id']) {
                            $snippetVar = SnippetVar::findOne($varData['id']);
                            $snippetVar->id = $varData['id'];
                        } else {
                            $snippetVar = new SnippetVar();
                        }
                        
                        $snippetVar->identifier = $varData['identifier'];
                        $snippetVar->type_id = $varData['type_id'];
                        $snippetVar->default_value = $varData['default_value'];
                        $snippetVar->description = $varData['description'];
                        $snippetVar->tmp_id = $varData['tmp_id'];

                        if (isset($varData['parent_id']) && $varData['parent_id']) {
                            $snippetVar->parent_id = $varData['parent_id'];
                        }
                        
                        $modelsSnippetVar[] = $snippetVar;
                    //}
                }
            }

            $oldVarsIDs = ArrayHelper::map($model->snippetVars, 'id', 'id');
            $newVarsIDs = ArrayHelper::map($modelsSnippetVar, 'id', 'id');

            $varsIDsToDelete = array_diff($oldVarsIDs, $newVarsIDs);
            
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                                ActiveForm::validateMultiple($modelsSnippetCode), ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate() && 
                    Model::validateMultiple($modelsSnippetCode) &&
                    Model::validateMultiple($modelsSnippetVar);

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    foreach ($codesIDsToDelete as $codeID) {
                        SnippetCode::findOne($codeID)->delete();
                    }

                    foreach ($varsIDsToDelete as $varID) {
                        $snippetVarToDelete = SnippetVar::findOne($varID);
                        if ($snippetVarToDelete) {
                            $snippetVarToDelete->delete();
                        }
                    }
                
                    if ($flag = $model->save(false)) {

                        foreach ($modelsSnippetCode as $modelSnippetCode) {
                            $modelSnippetCode->link('snippet', $model);

                            //TODO here will be code for change portals.
                            // Update snippet portals (alternatives of snippet).
//                            $portals_array = Yii::$app->request->post('snippet_code_portals');
//                            $portals_ids = !$portals_array ? : implode($portals_array, ',');
//                            $modelSnippetCode->portal = $portals_ids;

                            if (!($flag = $modelSnippetCode->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        
                        foreach ($modelsSnippetVar as $var) {
                            $var->snippet_id = $model->id;
                            $flag = $var->save(false);
                            
                            if (!($flag)) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        
                        // TODO --> to model
                        // Parent ids change back to id of parent.
                        foreach ($modelsSnippetVar as $savedVar) {
                            $parent = SnippetVar::find()
                                    ->where(['tmp_id' => $savedVar->parent_id])
                                    ->andWhere(['not', ['tmp_id' => null]])
                                    ->one(); 
                                if ($parent) {
                                    $savedVar->parent_id = strval($parent->id);
                                    $savedVar->save();
                                }
                            
                        }
                        
                        
                    }
                    if ($flag) {
                        //      $transaction->rollBack();
                        $transaction->commit();
                        return $this->redirect(['index']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'modelsSnippetCode' => (empty($modelsSnippetCode)) ? [new SnippetCode()] : $modelsSnippetCode,
            ]);
        }
    }

    public function actionAppendVar()
    {
       // echo $id; return;
        return $this->renderAjax('_variable', ['snippetVar' => new SnippetVar()]);
    }

    /**
     * Deletes an existing Snippet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Snippet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Snippet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Snippet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
