<?php

namespace backend\controllers;

use backend\models\Model;
use backend\models\PortalVar;
use backend\models\PortalVarValue;
use backend\models\Section;
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
        return array_merge(parent::behaviors(),[
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

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $modelsPortalVarValue = Model::createMultiple(PortalVarValue::classname());
            Model::loadMultiple($modelsPortalVarValue, Yii::$app->request->post());

            // TODO - refactor this - same code in ProductController
            $vars = Yii::$app->request->post('var');
            foreach ($vars as $id_var => $value)
            {
                $productVarValue = new PortalVarValue();
                $productVarValue->portal_id = $model->id;
                $productVarValue->var_id = $id_var;
                $productVarValue->value = $value[0];
                $productVarValue->save();
            }
            
            // ajax validation
            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsPortalVarValue),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsPortalVarValue) && $valid;

            if ($valid)
            {
                $transaction = \Yii::$app->db->beginTransaction();
                try
                {
                    if ($flag = $model->save(false))
                    {
                        foreach ($modelsPortalVarValue as $modelPortalVarValue)
                        {
                            $modelPortalVarValue->portal_id = $model->id;
                            if (!($flag = $modelPortalVarValue->save(false)))
                            {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag)
                    {
                        $transaction->commit();
                        $this->cacheEngine->cachePortal($model);
                        return $this->redirect(['index']);
                    }
                }
                catch (Exception $e)
                {
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

            $vars = Yii::$app->request->post('var');
            foreach ($model->portalVarValues as $var_value)
            {
                $var_value->delete();
            }
            
            foreach ($vars as $id_var => $value)
            {
                $productVarValue = new PortalVarValue();
                $productVarValue->portal_id = $model->id;
                $productVarValue->var_id = $id_var;
                $productVarValue->value = $value[0];
                $productVarValue->save();
            }
            
            // ajax validation
            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsPortalVarValue),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();

            $valid = Model::validateMultiple($modelsPortalVarValue) && $valid;

            if ($valid)
            {
                $transaction = \Yii::$app->db->beginTransaction();
                try
                {
                    if ($flag = $model->save(false))
                    {
                        if (! empty($deletedIDs))
                        {
                            PortalVar::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsPortalVarValue as $modelPortalVarValue)
                        {
                            $modelPortalVarValue->portal_id = $model->id;
                            if (! ($flag = $modelPortalVarValue->save(false)))
                            {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag)
                    {
                        $transaction->commit();
                        $this->cacheEngine->cachePortal($model);
                        return $this->redirect(['index']);
                    }
                }
                catch (Exception $e)
                {
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

    public function actionChangeCurrent($id)
    {
        $session = Yii::$app->session;
        $session->set('portal_id', $id);
        return $this->goBack();
    }
    
    public function actionHeaderCreate()
    {
        $sections = Section::findAll([
            'type' => 'header',
            'portal_id' => 4
        ]);

        return $this->render('header-create', [
            'sections' => $sections
        ]);
    }

    public function actionFooterCreate()
    {
        $sections = Section::findAll([
            'type' => 'footer',
            'portal_id' => 4
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
