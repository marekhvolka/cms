<?php

namespace backend\controllers;

use backend\models\ProductVar;
use backend\models\ProductVarValue;
use Yii;
use backend\models\Product;
use backend\models\ProductSearch;
use yii\helpers\ArrayHelper;
use backend\models\Model;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends BaseController
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $modelsProductVarValue = [new ProductVarValue()];

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $modelsProductVarValue = Model::createMultiple(ProductVarValue::classname());
            Model::loadMultiple($modelsProductVarValue, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsProductVarValue),
                    ActiveForm::validate($model)
                );
            }

            VarDumper::dump($modelsProductVarValue);
            die();

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsProductVarValue) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsProductVarValue as $modelProductVarValue) {
                            $modelProductVarValue->product_id = $model->id;
                            if (! ($flag = $modelProductVarValue->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelsProductVarValue' => (empty($modelsProductVarValue)) ? [new ProductVarValue()] : $modelsProductVarValue,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsProductVarValue = $model->productVarValues;

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $oldIDs = ArrayHelper::map($modelsProductVarValue, 'id', 'id');
            $modelsProductVarValue = Model::createMultiple(ProductVar::classname(), $modelsProductVarValue);
            Model::loadMultiple($modelsProductVarValue, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsProductVarValue, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsProductVarValue),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();

            $valid = Model::validateMultiple($modelsProductVarValue) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            ProductVar::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsProductVarValue as $modelProductVarValue) {
                            $modelProductVarValue->snippet_id = $model->id;
                            if (! ($flag = $modelProductVarValue->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
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
                'modelsProductVarValue' => (empty($modelsProductVarValue)) ? [new ProductVarValue()] : $modelsProductVarValue,
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
