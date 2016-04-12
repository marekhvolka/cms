<?php

namespace backend\controllers;

use backend\models\SnippetCode;
use MongoDB\Driver\Exception\Exception;
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
        $modelsSnippetVar = [];

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $modelsSnippetCode = Model::createMultiple(SnippetCode::classname());
            Model::loadMultiple($modelsSnippetCode, Yii::$app->request->post());
            
            /*
             * TODO - !!! this is hardcoded! should be refactor as follows (something like that):
             * 
             * $modelsSnippetVar2 = [new SnippetVar()];
             * $modelsSnippetVar2 = Model::createMultiple(SnippetVar::classname());
             * Model::loadMultiple($modelsSnippetVar2, Yii::$app->request->post());
             * 
             * At least refactor for using: $modelVar->load($varData, false);
             */
            
            $snippetVarData = Yii::$app->request->post('SnippetVar');
            foreach ($snippetVarData as $varData) {
                $modelVar = new SnippetVar();
                
                $modelVar->identifier = $varData['identifier'];
                $modelVar->type_id = $varData['type_id'];
                $modelVar->default_value = $varData['default_value'];
                $modelVar->description = $varData['description'];
                
                $modelsSnippetVar[] = $modelVar;
            }
            
            $modelsSnippetVar2 = [new SnippetVar()];
            $modelsSnippetVar2 = Model::createMultiple(SnippetVar::classname());
            Model::loadMultiple($modelsSnippetVar2, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsSnippetCode),
                    ActiveForm::validateMultiple($modelsSnippetVar),
                    ActiveForm::validate($model)
                );
            }
            
            // validate all models
            $valid = $model->validate() 
                    && Model::validateMultiple($modelsSnippetCode)
                    && Model::validateMultiple($modelsSnippetVar);
       
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsSnippetCode as $code) {
                            $code->link('snippet', $model);
                            
                            $snippet_code_portals_ids_array = Yii::$app->request->post('snippet_code_portals');
                            if ($snippet_code_portals_ids_array) {
                                $snippet_code_portals_ids = implode(",", $snippet_code_portals_ids_array);
                                $code->portal = $snippet_code_portals_ids;
                            }
                            $flag = $code->save(false);
                            if (!($flag)) {
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
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['index']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        else
        {
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
        
     //   $snippetVars = $model->snippetVars;
        $modelsSnippetCode = $model->snippetCodes;
        
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $snippetCodesToDelete = SnippetCode::find()->where(['snippet_id' => $model->id])->all();
            foreach ($snippetCodesToDelete as $code) {
                $code->delete();
            }

            $modelsSnippetCode = [new SnippetCode()];
            
            //$oldIDs = ArrayHelper::map($modelsSnippetCode, 'id', 'id');
            $modelsSnippetCode = Model::createMultiple(SnippetCode::classname(), $modelsSnippetCode);
            Model::loadMultiple($modelsSnippetCode, Yii::$app->request->post());
            //$deletedIDsSnippetCodes = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsSnippetCode, 'id', 'id')));
            
//            $oldIDs = ArrayHelper::map($snippetVars, 'id', 'id');
//            $snippetVars = Model::createMultiple(SnippetCode::classname(), $snippetVars);
//            Model::loadMultiple($snippetVars, Yii::$app->request->post());
//            $deletedIDsVars = array_diff($oldIDs, array_filter(ArrayHelper::map($snippetVars, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsSnippetCode),
                    ActiveForm::validate($model)
                );
            } 

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsSnippetCode) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        
                        
//                        foreach ($deletedIDsSnippetCodes as $id) {
//                            
//                        }
//                        
//                        if (!empty($deletedIDsVars)) {
//                            SnippetVar::deleteAll(['id' => $deletedIDsVars]);
//                        }
                        
                        foreach ($modelsSnippetCode as $modelSnippetCode) {
                            $modelSnippetCode->link('snippet', $model);
                            
                            // Update snippet portals (alternatives of snippet).
//                            $portals_array = Yii::$app->request->post('snippet_code_portals');
//                            $portals_ids = !$portals_array ? : implode($portals_array, ',');
//                            $modelSnippetCode->portal = $portals_ids;
                            
                            if (! ($flag = $modelSnippetCode->save(false))) {
                                $transaction->rollBack();
                                break;
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
        }
        else
        {
            return $this->render('update', [
                'model' => $model,
                'modelsSnippetCode' => (empty($modelsSnippetCode)) ? [new SnippetCode()] : $modelsSnippetCode,
            ]);
        }
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
