<?php

namespace backend\controllers;

use backend\models\SnippetCode;
use backend\models\SnippetVar;
use backend\models\SnippetVarDefaultValue;
use Exception;
use Yii;
use backend\models\Model;
use backend\models\Snippet;
use backend\models\search\SnippetSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

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

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Snippet model validated and saved.
                $modelValidatedAndSaved = $model->validate() && $model->save();
                
                $snippetCodesData = Yii::$app->request->post('SnippetCode');
                // Array of SnippetCode models used later for multiple validation.
                $snippetCodes = SnippetCode::createMultipleFromData($snippetCodesData);
                
                // SnippetCode models multiple loading, validation and saving.
                $loadedCodes = Model::loadMultiple($snippetCodes, Yii::$app->request->post());
                $validCodes = Model::validateMultiple($snippetCodes);
                $savedCodes = SnippetCode::saveMultiple($snippetCodes, $model);

                $snippetVarData = Yii::$app->request->post('SnippetVar');
                // Array of SnippetVar models used later for multiple validation.
                $snippetVars = SnippetVar::createMultipleFromData($snippetVarData);

                // SnippetCode models multiple loading validation and saving.
                $loadedVars = Model::loadMultiple($snippetVars, Yii::$app->request->post());
                $validVars = Model::validateMultiple($snippetVars);
                $savedVars = SnippetVar::saveMultiple($snippetVars, $model);

                $valid = $loadedCodes && $validCodes && $savedCodes && $loadedVars &&
                        $validVars && $savedVars && $modelValidatedAndSaved;

                if (!$valid) {
                    throw new Exception;
                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Uložené');

                $continue = Yii::$app->request->post('continue');

                if (isset($continue))
                    return $this->redirect(['update', 'id' => $model->id]);
                else
                    return $this->redirect(['index']);

            } catch (Exception $e) {
                $transaction->rollBack();
                
                Yii::$app->response->format = Response::FORMAT_JSON;
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
        $model = $this-> findModel($id);
        $snippetCodes = $model->snippetCodes;

        if ($model->load(Yii::$app->request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                // Snippet model validated and saved.
                $modelValidatedAndSaved = $model->validate() && $model->save();
                
                $snippetCodesData = Yii::$app->request->post('SnippetCode');     
                // Array of SnippetCode models used later for multiple validation.
                $snippetCodes = SnippetCode::createMultipleFromData($snippetCodesData);

                // SnippetCode models multiple loading, validation and saving.
                $loadedCodes = Model::loadMultiple($snippetCodes, Yii::$app->request->post());
                $validCodes = Model::validateMultiple($snippetCodes);
                $savedCodes = SnippetCode::saveMultiple($snippetCodes, $model);

                $snippetVarData = Yii::$app->request->post('SnippetVar');
                // Array of SnippetVar models used later for multiple validation.
                $snippetVars = SnippetVar::createMultipleFromData($snippetVarData);

                // SnippetCode models multiple loading, validation and saving.
                $loadedVars = Model::loadMultiple($snippetVars, Yii::$app->request->post());
                $validVars = Model::validateMultiple($snippetVars);
                $savedVars = SnippetVar::saveMultiple($snippetVars, $model);

                // Deleting and saving multiple SnippetCodes and SnippetVars in database.
                $codesDeletedSuccesfully = SnippetCode::deleteMultiple($snippetCodes, $model);
                $varsDeletedSuccesfully = SnippetVar::deleteMultiple($snippetVars, $model);
                

                $valid = $loadedCodes && $validCodes && $savedCodes && $codesDeletedSuccesfully && $loadedVars &&
                        $validVars && $savedVars && $varsDeletedSuccesfully && $modelValidatedAndSaved;

                if (!$valid) {
                    throw new Exception;
                }

                $transaction->commit();

                $continue = Yii::$app->request->post('continue');

                if (isset($continue))
                    return $this->redirect(['update', 'id' => $model->id]);
                else
                    return $this->redirect(['index']);

            } catch (Exception $e) {
                $transaction->rollBack();
                return $this->render('create', [
                            'model' => $model,
                            'snippetCodes' => $snippetCodes,
                            'snippetVars' => $snippetVars,
                ]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'snippetCodes' => (empty($snippetCodes)) ? [new SnippetCode()] : $snippetCodes,
            ]);
        }
    }

    /**
     * Ajax action for appending one code (HTML in partial view) at the end
     * of codes list. 
     * @return string rendered view for one code.
     */
    public function actionAppendCode()
    {
        return $this->renderAjax('_code', ['snippetCode' => new SnippetCode()]);
    }

    /**
     * Ajax action for appending one variable (HTML in partial view) at the end
     * of variable list. 
     * @param int $id parents id (list type parent), default null - variable is without parent.
     * @return string rendered view for one variable.
     */
    public function actionAppendVar($id = null)
    {
        return $this->renderAjax('_variable', ['snippetVar' => new SnippetVar(), 'parentId' => $id]);
    }

    /**
     * Ajax action for appending one wrapper of list item types children 
     * variables of list type variable (HTML in partial view).
     * @param int $id parents id (list type parent), default null - variable 
     * is without parent and new SnippetVar is created.
     * @return string rendered view for one wrapper box.
     */
    public function actionAppendChildVarBox($id = null)
    {
        $snippetVar = $id == null ? new SnippetVar() : SnippetVar::find()->where(['id' => $id])->one();
        return $this->renderAjax('_child-var-box', ['snippetVar' => $snippetVar]);
    }

    /**
     * Ajax action for appending one wrapper of
     * @return string rendered view for one wrapper box.
     */
    public function actionAppendDefaultValue()
    {
        return $this->renderAjax('_variable-default-val', ['defaultValue' => new SnippetVarDefaultValue()]);
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
