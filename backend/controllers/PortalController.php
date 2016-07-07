<?php

namespace backend\controllers;

use backend\components\VarManager\VarManagerWidget;
use backend\models\Block;
use backend\models\Model;
use backend\models\Portal;
use backend\models\PortalVar;
use backend\models\PortalVarValue;
use backend\models\search\PortalSearch;
use Exception;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

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

                    if (!key_exists('SnippetVarValue', $portalValueData)) {
                        continue;
                    }

                    $model->portalVarValues[$index]->changed = true;

                    if (!$model->portalVarValues[$index]->valueBlock) {
                        $block = new Block();
                        $block->type = 'snippet';
                        $block->portal_var_value_id = $model->portalVarValues[$index]->id;

                        $model->portalVarValues[$index]->valueBlock = $block;
                    }

                    $this->loadSnippetVarValues($portalValueData, $model->portalVarValues[$index]->valueBlock);
                }

                foreach($model->portalVarValues as $portalVarValue) {
                    $portalVarValue->portal_id = $model->id;
                    if (!($portalVarValue->validate() && $portalVarValue->save()))
                        throw new Exception;

                    if ($portalVarValue->valueBlock) {
                        if (!($portalVarValue->valueBlock->validate() && $portalVarValue->valueBlock->save())) {
                            throw new Exception;
                        }

                        if ($portalVarValue->changed) {
                            $this->saveSnippetVarValues($portalVarValue->valueBlock);
                        }
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

        if (isset($modelId)) {
            $model = Portal::findOne($modelId);
        }

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

        if (Yii::$app->request->isPost) {

            $transaction = Yii::$app->db->beginTransaction();
            try {

                $areaData = Yii::$app->request->post($type);
                $model->{$type}->load($areaData);
                $this->loadLayout($model->{$type}, $areaData);

                $model->{$type}->portal_id = $model->id;
                $this->saveLayout($model->{$type});

                $model->{$type}->resetAfterUpdate();

                $transaction->commit();
            } catch (Exception $exc) {
                $transaction->rollBack();

                return $this->render('layout-edit', [
                    'model' => $model,
                    'type' => $type
                ]);
            }
        }

        return $this->render('layout-edit', [
            'model' => $model,
            'type' => $type
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
