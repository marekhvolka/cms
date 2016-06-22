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
     * Edit an Portal model.
     * If edit is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id = null)
    {
        if ($id) {
            $model = $this->findModel($id); // Portal model retrieved by id.
            $portalVarValues = $model->portalVarValues;
        }
        else {
            $model = new Portal();
            $portalVarValues = [];
        }
        if ($model->load(Yii::$app->request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();

            try {
                $portalVarValuesData = Yii::$app->request->post('PortalVarValue');
                $portalVarValues = []; // Array of PortalVarValue models used later for multiple validation.
                // $portalVarValues array appended with retrieved existing PortalVarValue
                // models or with newly created ones.
                foreach ($portalVarValuesData as $i => $portalValueData) {
                    // If 'existing' flag is true, PortalVarValue model is retrieved.
                    if ($portalValueData['existing'] == 'true') {
                        $portalVarValue = PortalVarValue::find()
                            ->where(['id' => $portalValueData['id']])
                            ->one();
                    } else {
                        $portalVarValue = new PortalVarValue();
                    }
                    $portalVarValues[$i] = $portalVarValue;
                }

                // Portal model validated and saved.
                $modelValidatedAndSaved = $model->validate() && $model->save();
                // PortalVarValue models multiple loading and validation.
                $loaded = Model::loadMultiple($portalVarValues, Yii::$app->request->post());
                $valid = Model::validateMultiple($portalVarValues);

                if (!$loaded || !$valid || !$modelValidatedAndSaved) {
                    throw new Exception;
                }

                $this->savePortalVarValues($portalVarValues, $model);// Save PortalVarValue models.
                $this->deletePortalVarValues($portalVarValues, $model);// Delete PortalVarValue models.

                $transaction->commit(); // There was no error, models was validated and saved correctly.

                $model->resetAfterUpdate();
                return $this->redirect(['index']);

            } catch (Exception $e) {
                // There was problem with validation or saving models or another exception was thrown.
                $transaction->rollBack();
                return $this->render('edit', [
                    'model' => $model,
                    'portalVarValues' => (empty($portalVarValues)) ? [] : $portalVarValues,
                    'allVariables' => PortalVar::find()->all(),
                ]);
            }
        } else {
            return $this->render('edit', [
                'model' => $model,
                'portalVarValues' => (empty($portalVarValues)) ? [] : $portalVarValues,
                'allVariables' => PortalVar::find()->all(),
            ]);
        }
    }

    private function savePortalVarValues($portalVarValues, $model)
    {
        // Each PortalVarValue model saved individually.
        foreach ($portalVarValues as $portalVarValue) {
            $portalVarValue->portal_id = $model->id;
            if (!$portalVarValue->save()) {
                throw new Exception;
            }
        }
    }

    private function deletePortalVarValues($portalVarValues, $model)
    {
        // IDs of newly created or updated PortalVarValues.
        $newIDs = ArrayHelper::map($portalVarValues, 'id', 'id');
        // IDs of all PortalVarValues with PortalVarValues which user deleted.
        $allPortalVarValues = PortalVarValue::find()
            ->where(['portal_id' => $model->id])
            ->all();
        $oldIDs = ArrayHelper::map($allPortalVarValues, 'id', 'id');

        $deletedIDs = array_diff($oldIDs, $newIDs); // IDs of PortalVarValues to be deleted.
        $portalVarValuesToDelete = PortalVarValue::find()->where(['id' => $deletedIDs])->all();

        // Deleting PortalVarValues.
        foreach ($portalVarValuesToDelete as $varValueToDelete) {
            $deleted = $varValueToDelete->delete();
            if (!$deleted) {
                throw new Exception();
            }
        }
    }

    /**
     * Action neccessary for VarManagerWidget - appending one variable value at the end of the list.
     * @param Model $id - id of Var
     * @return string - call of VarManagerWidget method for rendering view of VarValue.
     */
    public function actionAppendVarValue($id)
    {
        $varValue = new PortalVarValue();
        $varValue->var_id = $id;

        return (new VarManagerWidget())->appendVariableValue($varValue);
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
        $allSections = Section::findAll([
            'type' => $type,
            'portal_id' => Yii::$app->session->get('portal_id')
        ]);

        if (Yii::$app->request->isPost) {

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $sections = array();
                $rows = array();
                $columns = array();
                $blocks = array();

                foreach($allSections as $section) {
                    $sections[$section->id] = $section;
                    foreach($section->rows as $row) {
                        $rows[$row->id] = $row;

                        foreach ($row->columns as $column) {
                            $columns[$column->id] = $column;

                            foreach ($column->blocks as $block) {
                                $blocks[$block->id] = $block;
                            }
                        }
                    }
                }

                // Getting all data for creating/updating sections, rows, columns and blocks.
                $sectionsData = Yii::$app->request->post('Section');
                foreach($sectionsData as $index => $item) {
                    Section::loadFromData($sections, $item, $index, Section::className());
                }

                $rowsData = Yii::$app->request->post('Row');
                foreach($rowsData as $index => $item) {
                    Row::loadFromData($rows, $item, $index, Row::className());
                }

                $columnsData = Yii::$app->request->post('Column');
                foreach($columnsData as $index => $item) {
                    Column::loadFromData($columns, $item, $index, Column::className());
                }

                $blocksData = Yii::$app->request->post('Block');
                foreach($blocksData as $index => $item) {
                    Block::loadFromData($blocks, $item, $index, Block::className());
                }

                $validSections = Model::validateMultiple($sections);
                $validRows = Model::validateMultiple($rows);
                $validColumns = Model::validateMultiple($columns);
                $validBlocks = Model::validateMultiple($blocks);

                if (!($validSections && $validRows && $validColumns && $validBlocks))
                    throw new \yii\base\Exception;

                /* @var $section Section */
                foreach($sections as $section) {
                    if ($section->removed)
                        $section->delete();
                    else
                        $section->save();
                }

                foreach($rows as $row) {
                    if ($row->removed)
                        $row->delete();
                    else {
                        if (!$row->existing)
                            $row->section_id = $sections[$row->section_id]->id;
                        $row->save();
                    }
                }

                foreach($columns as $column) {
                    if ($column->removed)
                        $column->delete();
                    else {
                        if (!$column->existing)
                            $column->row_id = $rows[$column->row_id]->id;
                        $column->save();
                    }
                }

                foreach($blocks as $block) {
                    if ($block->removed)
                        $block->delete();
                    else {
                        if (!$block->existing)
                            $block->column_id = $columns[$block->column_id]->id;
                        $block->save();
                    }
                }

                $transaction->commit();
            } catch (Exception $exc) {
                $transaction->rollBack();

                return $this->render('layout-edit', [
                    'sections' => $sections
                ]);
            }
        }

        return $this->render('layout-edit', [
            'sections' => $allSections
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
