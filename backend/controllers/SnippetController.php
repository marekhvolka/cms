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
            //Creating multiple SnippetVars and SnippetCodes from posted data.
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
                    $flag = $model->save(false);
                    
                    // Deleting and saving multiple SnippetCodes and SnippetVars in database.
                    SnippetCode::deleteMultiple($modelSnippetCodes, $model);
                    SnippetVar::deleteMultiple($modelSnippetVars, $model);

                    $flagCodes = SnippetCode::saveMultiple($modelSnippetCodes, $model);
                    $flagVars = SnippetVar::saveMultiple($modelSnippetVars, $model);
                    
                    if ($flag && $flagCodes && $flagVars) {
                        $transaction->commit();
                        return $this->redirect(['index']);
                    } else {    // TODO does not have to be else{}
                        $transaction->rollBack();
                        return;     // TODO - handle error
                    }
                    
                } catch (Exception $e) {
                    $transaction->rollBack();
                    return;     // TODO - handle error
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
