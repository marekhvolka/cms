<?php

namespace backend\controllers;

use backend\components\VarManager\VarManagerWidget;
use backend\models\Block;
use backend\models\Model;
use backend\models\Portal;
use backend\models\PortalVar;
use backend\models\PortalVarValue;
use backend\models\search\PortalSearch;
use common\components\Alert;
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
        $model = $id ? $this->findModel($id) : new Portal();
        $allVariables = PortalVar::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax && !Yii::$app->request->post('ajaxSubmit')) { // ajax validácia
                return $this->ajaxValidation($model);
            }
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $model->validateAndSave();

                $portalVarValuesData = Yii::$app->request->post('Var');
                if ($portalVarValuesData) {
                    foreach ($portalVarValuesData as $index => $portalValueData) {
                        $model->loadFromData('portalVarValues', $portalValueData, $index, PortalVarValue::className());

                        if (!key_exists('SnippetVarValue', $portalValueData)) {
                            continue;
                        }

                        if (!$model->portalVarValues[$index]->valueBlock) {
                            $block = new Block();
                            $block->type = 'snippet';

                            $model->portalVarValues[$index]->valueBlock = $block;
                        }

                        $model->portalVarValues[$index]->valueBlock->snippet_code_id = $portalValueData['snippet_code_id'];

                        $this->loadSnippetVarValues($portalValueData, $model->portalVarValues[$index]->valueBlock);
                    }

                    foreach ($model->portalVarValues as $indexPortalVarValue => $portalVarValue) {
                        $portalVarValue->portal_id = $model->id;

                        if ($portalVarValue->removed) {

                            if ($portalVarValue->valueBlock) {
                                $portalVarValue->valueBlock->delete();
                            }
                            $portalVarValue->delete();
                            unset($model->portalVarValues[$indexPortalVarValue]);
                            continue;
                        }

                        $portalVarValue->validateAndSave();

                        if ($portalVarValue->valueBlock) {
                            $portalVarValue->valueBlock->portal_var_value_id = $portalVarValue->id;

                            $portalVarValue->valueBlock->validateAndSave();

                            if ($portalVarValue->valueBlock->isChanged()) {
                                $this->saveSnippetVarValues($portalVarValue->valueBlock);
                            }
                        }
                    }
                }

                $transaction->commit(); // There was no error, models was validated and saved correctly.

                $model->setOutdated();

                return $this->redirectAfterSave($model, ['allVariables' => $allVariables]);
            } catch (Exception $e) {
                $transaction->rollBack();
                return $this->redirectAfterFail($model, ['allVariables' => $allVariables]);
            }
        } else {
            return $this->render('edit', [
                'model' => $model,
                'allVariables' => $allVariables
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

        $var = PortalVar::findOne(Yii::$app->request->post('varId'));
        $varValue->var_id = $var->id;

        if ($var->isSnippet()) {
            $varValue->valueBlock = new Block();
            $varValue->valueBlock->type = 'snippet';
        }

        $modelId = Yii::$app->request->post('modelId');

        $model = null;

        if (isset($modelId)) {
            $model = Portal::findOne($modelId);
        }
        $prefix = Yii::$app->request->post('prefix');

        $indexVar = rand(1000, 100000);

        return (new VarManagerWidget())->appendVariableValue($varValue, $prefix, $indexVar, $model);
    }

    public function actionHardReset($id)
    {
        Portal::findOne($id)->getMainCacheFile(true);
    }

    public function actionLayoutEdit($type)
    {
        $model = Yii::$app->user->identity->portal;

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

                return $this->redirectAfterSave($model, ['type' => $type], 'layout-edit');
            } catch (Exception $exc) {
                $transaction->rollBack();
                return $this->redirectAfterFail($model, ['type' => $type], 'layout-edit');
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
            throw new NotFoundHttpException('Požadovaná stránka neexistuje.');
        }
    }
}