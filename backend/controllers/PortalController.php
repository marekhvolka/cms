<?php

namespace backend\controllers;

use backend\models\Model;
use backend\models\PortalVar;
use backend\models\PortalVarValue;
use MongoDB\Driver\Exception\Exception;
use Yii;
use backend\models\Portal;
use backend\models\search\PortalSearch;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * PortalController implements the CRUD actions for Portal model.
 */
class PortalController extends BaseController
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
     * Lists all Portal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PortalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Portal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Portal();
        $modelsPortalVarValue = [new PortalVarValue()];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $modelsPortalVarValue = Model::createMultiple(PortalVarValue::classname());
            Model::loadMultiple($modelsPortalVarValue, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsPortalVarValue),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsPortalVarValue) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsPortalVarValue as $modelPortalVarValue) {
                            $modelPortalVarValue->portal_id = $model->id;
                            if (!($flag = $modelPortalVarValue->save(false))) {
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
                'modelsPortalVarValue' => (empty($modelsPortalVarValue)) ? [new PortalVarValue()] : $modelsPortalVarValue,

            ]);
        }
    }

    /**
     * Updates an existing Portal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsPortalVarValue = $model->portalVarValues;

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $oldIDs = ArrayHelper::map($modelsPortalVarValue, 'id', 'id');
            $modelsPortalVarValue = Model::createMultiple(PortalVar::classname(), $modelsPortalVarValue);
            Model::loadMultiple($modelsPortalVarValue, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsPortalVarValue, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsPortalVarValue),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();

            $valid = Model::validateMultiple($modelsPortalVarValue) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            PortalVar::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsPortalVarValue as $modelPortalVarValue) {
                            $modelPortalVarValue->portal_id = $model->id;
                            if (! ($flag = $modelPortalVarValue->save(false))) {
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
                'modelsPortalVarValue' => (empty($modelsPortalVarValue)) ? [new PortalVarValue()] : $modelsPortalVarValue,
            ]);
        }
    }

    /**
     * Deletes an existing Portal model.
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
     * Finds the Portal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Portal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Portal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
