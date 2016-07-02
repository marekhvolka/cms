<?php

namespace backend\controllers;

use backend\components\VarManager\VarManagerWidget;
use backend\models\CustomModel;
use common\components\ParseEngine;
use Exception;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use backend\models\Model;
use backend\models\PortalVar;
use backend\models\PortalVarValue;
use backend\models\Section;
use backend\models\Row;
use backend\models\Column;
use backend\models\Block;
use backend\models\Portal;
use backend\models\search\PortalSearch;

/**
 * PortalController implements the CRUD actions for Portal model.
 */
class PortalController extends BaseController
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
     * Edits an Portal model.
     * If edit is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id = null)
    {
        if ($id) {
            $model = $this->findModel($id); // Portal model retrieved by id
        } else {
            $model = new Portal();
        }

        if ($model->load(Yii::$app->request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();

            try {
                $portalVarValuesData = Yii::$app->request->post('Var');

                if (!($model->validate() && $model->save())) {
                    throw new Exception;
                }

                foreach ($portalVarValuesData as $index => $portalValueData) {
                    $model->loadFromData('portalVarValues', $portalValueData, $index, PortalVarValue::className());
                }

                foreach ($model->portalVarValues as $portalVarValue) {
                    $portalVarValue->portal_id = $model->id;
                    if (!($portalVarValue->validate() && $portalVarValue->save())) {
                        throw new Exception;
                    }
                }

                $transaction->commit(); // There was no error, models was validated and saved correctly.

                $model->resetAfterUpdate();

                return $this->redirect(['index']);
            } catch (Exception $e) {
                // There was problem with validation or saving models or another exception was thrown.
                $transaction->rollBack();
                return $this->render('edit', [
                    'model' => $model,
                    'allVariables' => PortalVar::find()->all(),
                ]);
            }
        } else {
            return $this->render('edit', [
                'model' => $model,
                'allVariables' => PortalVar::find()->all()
            ]);
        }
    }

    /**
     * Action necessary for VarManagerWidget - appending one variable value at the end of the list.
     * @return string - call of VarManagerWidget method for rendering view of VarValue.
     */
    public function actionAppendVarValue()
    {
        $varValue = new PortalVarValue();
        $varValue->var_id = Yii::$app->request->post('varId');

        $modelId = Yii::$app->request->post('modelId');

        $model = null;

        if (isset($modelId))
            $model = Portal::findOne($modelId);

        $prefix = Yii::$app->request->post('prefix');

        $indexVar = rand(1000, 100000);

        return (new VarManagerWidget())->appendVariableValue($varValue, $prefix, $indexVar, $model);
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

    public function actionLayoutEdit($type)
    {
        $model = $this->findModel(Yii::$app->session->get('portal_id'));

        if ($type == 'header') {
            $propertyIdentifier = 'headerSections';
        } else if ($type == 'footer') {
            $propertyIdentifier = 'footerSections';
        } else {
            return '';
        }

        if (Yii::$app->request->isPost) {

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $sectionsData = Yii::$app->request->post('section');

                $this->loadLayout($model, $sectionsData, $propertyIdentifier);
                $this->saveLayout($model, $propertyIdentifier);

                $transaction->commit();
            } catch (Exception $exc) {
                $transaction->rollBack();

                return $this->render('layout-edit', [
                    'model' => $model,
                    'propertyIdentifier' => $propertyIdentifier
                ]);
            }
        }

        return $this->render('layout-edit', [
            'model' => $model,
            'propertyIdentifier' => $propertyIdentifier
        ]);
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
