<?php

namespace backend\controllers;

use backend\models\SnippetCode;
use backend\models\SnippetVar;
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

/**
 * SnippetController implements the CRUD actions for Snippet model.
 */
class SnippetController extends BaseController
{

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ]);
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
        $snippetCodes = [];

        if ($model->load(Yii::$app->request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $snippetCodesData = Yii::$app->request->post('SnippetCode');
                // Array of SnippetCode models used later for multiple validation.
                // $snippetCodesData array appended with retrieved newly created SnippetCode models.
                foreach ($snippetCodesData as $i => $codeData) {
                    $snippetCode = new SnippetCode();
                    $snippetCodes[$i] = $snippetCode;
                }

                // Snippet model validated and saved.
                $modelValidatedAndSaved = $model->validate() && $model->save();

                // SnippetCode models multiple loading, validation and saving.
                $loadedCodes = Model::loadMultiple($snippetCodes, Yii::$app->request->post());
                $validCodes = Model::validateMultiple($snippetCodes);
                $savedCodes = SnippetCode::saveMultiple($snippetCodes, $model);

                $snippetVarData = Yii::$app->request->post('SnippetVar');
                $snippetVars = [];

                foreach ($snippetVarData as $i => $varData) {
                    $snippetVar = new SnippetVar();
                    $snippetVars[$i] = $snippetVar;
                }

                // SnippetCode models multiple loading and validation.
                $loadedVars = Model::loadMultiple($snippetVars, Yii::$app->request->post());
                $validVars = Model::validateMultiple($snippetVars);
                $savedVars = SnippetVar::saveMultiple($snippetVars, $model);

                $valid = $loadedCodes && $validCodes && $savedCodes && $loadedVars && $validVars && $savedVars && $modelValidatedAndSaved;

                if (!$valid) {
                    throw new Exception;
                }

                $transaction->commit();
                return $this->redirect(['index']);


//                // ajax validation
//                if (Yii::$app->request->isAjax) {
//                    Yii::$app->response->format = Response::FORMAT_JSON;
//                    return ArrayHelper::merge(
//                                    ActiveForm::validateMultiple($snippetCodes), ActiveForm::validateMultiple($modelSnippetVars), ActiveForm::validate($model)
//                    );
//                }
               
            } catch (Exception $e) {
                $transaction->rollBack();
                return $this->render('create', [
                            'model' => $model,
                            'snippetCodes' => $snippetCodes,
                            'snippetVars' => $snippetVars,
                ]);
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
        $snippetCodes = $model->snippetCodes;

        if ($model->load(Yii::$app->request->post())) {
            //Creating multiple SnippetVars and SnippetCodes from posted data.
            $snippetCodeData = Yii::$app->request->post('SnippetCode');
            $snippetCodes = SnippetCode::createMultipleFromData($snippetCodeData);

            $snippetVarData = Yii::$app->request->post('SnippetVar');
            $modelSnippetVars = SnippetVar::createMultipleFromData($snippetVarData);

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                                ActiveForm::validateMultiple($snippetCodes), ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate() &&
                    Model::validateMultiple($snippetCodes) &&
                    Model::validateMultiple($modelSnippetVars);

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    $flag = $model->save(false);

                    // Deleting and saving multiple SnippetCodes and SnippetVars in database.
                    SnippetCode::deleteMultiple($snippetCodes, $model);
                    SnippetVar::deleteMultiple($modelSnippetVars, $model);

                    $flagCodes = SnippetCode::saveMultiple($snippetCodes, $model);
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
                        'snippetCodes' => (empty($snippetCodes)) ? [new SnippetCode()] : $snippetCodes,
            ]);
        }
    }

    public function actionAppendCode()
    {
        return $this->renderAjax('_code', ['snippetCode' => new SnippetCode()]);
    }

    /**
     * 
     * @param int $id parents id (list type parent), default null - variable is without parent.
     * @return type
     */
    public function actionAppendVar($id = null)
    {
        return $this->renderAjax('_variable', ['snippetVar' => new SnippetVar(), 'parentId' => $id]);
    }

    public function actionAppendChildVarBox($id = null)
    {
        $snippetVar = $id == null ? new SnippetVar() : SnippetVar::find()->where(['id' => $id])->one();
        return $this->renderAjax('_child-var-box', ['snippetVar' => $snippetVar]);
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
