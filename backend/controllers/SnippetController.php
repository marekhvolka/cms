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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $snippetCodeData = Yii::$app->request->post('SnippetCode');
            $modelSnippetCodes = SnippetCode::createMultipleFromData($snippetCodeData);
            
            $snippetVarData = Yii::$app->request->post('SnippetVar');
            $modelSnippetVars = SnippetVar::createMultipleFromData($snippetVarData);

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                                ActiveForm::validateMultiple($modelSnippetCodes), ActiveForm::validateMultiple($modelSnippetVars), ActiveForm::validate($model)
                );
            }
            
            // validate all models
            $valid = $model->validate() && 
                    Model::validateMultiple($modelSnippetCodes) &&
                    Model::validateMultiple($modelSnippetVars);

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        
                        $flagCodes = SnippetCode::saveMultiple($modelSnippetCodes, $model);
                        $flagVars = SnippetVar::saveMultiple($modelSnippetVars, $model);
                        
                        if (!$flagCodes || !$flagVars) {
                            $transaction->rollBack();
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
                        'snippetCodes' => [new SnippetCode()],
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
        $modelSnippetCodes = $model->snippetCodes;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $snippetCodeData = Yii::$app->request->post('SnippetCode');
            $modelSnippetCodes = SnippetCode::createMultipleFromData($snippetCodeData);
            
            $snippetVarData = Yii::$app->request->post('SnippetVar');
            $modelSnippetVars = SnippetVar::createMultipleFromData($snippetVarData);
            
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                                ActiveForm::validateMultiple($modelSnippetCodes), ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate() && 
                    Model::validateMultiple($modelSnippetCodes) &&
                    Model::validateMultiple($modelSnippetVars);

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    $oldCodesIDs = ArrayHelper::map($model->snippetCodes, 'id', 'id');
                    $newCodesIDs = ArrayHelper::map($modelSnippetCodes, 'id', 'id');
                    $codesIDsToDelete = array_diff($oldCodesIDs, $newCodesIDs);
                    
                    foreach ($codesIDsToDelete as $codeID) {
                        SnippetCode::findOne($codeID)->delete();
                    }

                    
                    $oldVarsIDs = ArrayHelper::map($model->snippetVars, 'id', 'id');
                    $newVarsIDs = ArrayHelper::map($modelSnippetVars, 'id', 'id');
                    $varsIDsToDelete = array_diff($oldVarsIDs, $newVarsIDs);
                    
                    foreach ($varsIDsToDelete as $varID) {
                        $snippetVarToDelete = SnippetVar::findOne($varID);
                        if ($snippetVarToDelete) {
                            $snippetVarToDelete->delete();
                        }
                    }
                
                    if ($flag = $model->save(false)) {

                        foreach ($modelSnippetCodes as $modelSnippetCode) {
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
                        
                        foreach ($modelSnippetVars as $var) {
                            $var->snippet_id = $model->id;
                            $flag = $var->save(false);
                            
                            if (!($flag)) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        
                        // TODO --> to model
                        // Parent ids change back to id of parent.
                        foreach ($modelSnippetVars as $savedVar) {
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
            return $this->render('update', [
                        'model' => $model,
                        'snippetCodes' => (empty($modelSnippetCodes)) ? [new SnippetCode()] : $modelSnippetCodes,
            ]);
        }
    }
    
    public function actionAppendCode()
    {
        return $this->renderAjax('_code', ['snippetCode' => new SnippetCode()]);
    }
    
    public function actionAppendVar()
    {
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
