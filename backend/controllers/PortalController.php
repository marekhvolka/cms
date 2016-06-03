<?php

namespace backend\controllers;

use Exception;
use Yii;
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

            // TODO - refactor this - same code in ProductController
            $vars = Yii::$app->request->post('var');
            foreach ($vars as $id_var => $value) {
                $productVarValue = new PortalVarValue();
                $productVarValue->portal_id = $model->id;
                $productVarValue->var_id = $id_var;
                $productVarValue->value = $value[0];
                $productVarValue->save();
            }

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                                ActiveForm::validateMultiple($modelsPortalVarValue), ActiveForm::validate($model)
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
                        $this->cacheEngine->cachePortal($model);
                        return $this->redirect(['index']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        } else {
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $oldIDs = ArrayHelper::map($modelsPortalVarValue, 'id', 'id');
            $modelsPortalVarValue = Model::createMultiple(PortalVar::classname(), $modelsPortalVarValue);
            Model::loadMultiple($modelsPortalVarValue, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsPortalVarValue, 'id', 'id')));

            $vars = Yii::$app->request->post('var');
            foreach ($model->portalVarValues as $var_value) {
                $var_value->delete();
            }

            foreach ($vars as $id_var => $value) {
                $productVarValue = new PortalVarValue();
                $productVarValue->portal_id = $model->id;
                $productVarValue->var_id = $id_var;
                $productVarValue->value = $value[0];
                $productVarValue->save();
            }

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                                ActiveForm::validateMultiple($modelsPortalVarValue), ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();

            $valid = Model::validateMultiple($modelsPortalVarValue) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (!empty($deletedIDs)) {
                            PortalVar::deleteAll(['id' => $deletedIDs]);
                        }
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
                        $this->cacheEngine->cachePortal($model);
                        return $this->redirect(['index']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        } else {
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

    public function actionHeaderCreate()
    {
        if (Yii::$app->request->isPost) {
            $test = 0;
        }

        $sections = Section::findAll([
                    'type' => 'header',
                    'portal_id' => Yii::$app->session->get('portal_id')
        ]);

        return $this->render('header-create', [
                    'sections' => $sections
        ]);
    }

    
    // TODO - move this action to LayoutController
    public function actionFooterCreate()
    {
        if (Yii::$app->request->isPost) {
            $sectionsData = Yii::$app->request->post('Section');
            $rowsData = Yii::$app->request->post('Row');
            $columnsData = Yii::$app->request->post('Column');
            $blocksData = Yii::$app->request->post('Block');

            $sections = Section::createMultipleFromData($sectionsData);
            $rows = Row::createMultipleFromData($rowsData);
            $columns = Column::createMultipleFromData($columnsData);
            $blocks = Block::createMultipleFromData($blocksData);

            $loadedSections = Model::loadMultiple($sections, Yii::$app->request->post());
            $validSections = Model::validateMultiple($sections);
           
            $loadedRows = Model::loadMultiple($rows, Yii::$app->request->post());
            $validRows = Model::validateMultiple($rows);

            $loadedColumns = Model::loadMultiple($columns, Yii::$app->request->post());
            $validColumns = Model::validateMultiple($columns);

            $loadedBlocks = Model::loadMultiple($blocks, Yii::$app->request->post());
            $validBlocks = Model::validateMultiple($blocks);

            foreach ($sections as $section) {
                $formerId = $section->id;
                if (!$section->save()) {
                    return false;
                }

                if ($section->existing == 'false') {   // TODO or if ($formerId != $section->id)
                    foreach ($rows as $row) {
                        if ($row->section_id == $formerId) {
                            $row->section_id = $section->id;
                        }
                    }
                }
            }

            foreach ($rows as $row) {
                $formerId = $row->id;
                if (!$row->save()) {
                    return false;
                }

                if ($row->existing == 'false') {   // TODO or if ($formerId != $section->id)
                    foreach ($columns as $column) {
                        if ($column->row_id == $formerId) {
                            $column->row_id = $row->id;
                        }
                    }
                }
            }

            foreach ($columns as $column) {
                $formerId = $column->id;
                if (!$column->save()) {
                    return false;
                }

                if ($column->existing == 'false') {   // TODO or if ($formerId != $section->id)
                    foreach ($blocks as $block) {
                        if ($block->column_id == $formerId) {
                            $block->column_id = $column->id;
                        }
                    }
                }
            }
            
            foreach ($blocks as $block) {
                if (!$block->save()) {
                    return false;
                }
            }
            
            // TODO - add ordering functionality
            // TODO here comes deleting 
            
            
            
        }

        $sections = Section::findAll([
                    'type' => 'footer',
                    'portal_id' => Yii::$app->session->get('portal_id')
        ]);

        return $this->render('header-create', [
                    'sections' => $sections
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
