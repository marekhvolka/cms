<?php

namespace backend\controllers;

use backend\models\ProductVar;
use backend\models\ProductVarValue;
use MongoDB\Driver\Exception\Exception;
use Yii;
use backend\models\Product;
use backend\models\search\ProductSearch;
use yii\helpers\ArrayHelper;
use backend\models\Model;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use backend\components\VarManager2\VarManagerWidget;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends BaseController
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $productVarValues = [];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $productVarValuesData = Yii::$app->request->post('ProductVarValue');

                foreach ($productVarValuesData as $id => $productValueData) {
                    $productVarValue = new ProductVarValue();
                    $this->setProductValueAttributesAndSave($model, $productVarValue, $productValueData);
                }

                $transaction->commit();
                return $this->redirect(['index']);
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        } else {
            // If model is not successfully saved, page is reloaded with error messages.
            // There must be appended all variables set by user previously.
            if (Yii::$app->request->isPost) {
                $productVarValuesData = Yii::$app->request->post('ProductVarValue'); 
                foreach ($productVarValuesData as $id => $productValueData) {
                    $productVarValue = new ProductVarValue();
                    $productVarValue->attributes = $productValueData;
                    $productVarValue->product_id = $model->id;
                    $productVarValues[] = $productVarValue;
                }
            }
            
            return $this->render('update', [
                        'model' => $model,
                        'productVarValues' => (empty($productVarValues)) ?
                                [] : $productVarValues,
                        'allVariables' => ProductVar::find()->all(),
            ]);
        }
    }

    private function setProductValueAttributesAndSave($product, $productVarValue, $productValueData)
    {
        $productVarValue->attributes = $productValueData;
        $productVarValue->product_id = $product->id;

        if (!$productVarValue->validate() || !$productVarValue->save()) {
            throw new Exception();
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
        $productVarValues = $model->productVarValues;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $transaction = \Yii::$app->db->beginTransaction();

            try {
                $productVarValuesData = Yii::$app->request->post('ProductVarValue');

                foreach ($productVarValuesData as $id => $productValueData) {
                    if ($productValueData['existing'] == 'true') {
                        $productVarValue = ProductVarValue::find()->where(['id' => $id])->one();
                    } else {
                        $productVarValue = new ProductVarValue();
                    }

                    $this->setProductValueAttributesAndSave($model, $productVarValue, $productValueData);
                }
                
                $this->deleteVarValues($productVarValues, $productVarValuesData);

                $transaction->commit();
                //$this->cacheEngine->cacheProduct($model); // TODO - CacheEngine call was here
                return $this->redirect(['index']);
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'productVarValues' => (empty($productVarValues)) ? [] : $productVarValues,
                        'allVariables' => ProductVar::find()->all(),
            ]);
        }
    }

    private function deleteVarValues($productVarValues, $productVarValuesData)
    {

        $oldIDs = ArrayHelper::map($productVarValues, 'id', 'id');
        $newIDs = ArrayHelper::map($productVarValuesData, 'id', 'id');

        $deletedIDs = array_diff($oldIDs, $newIDs);
        $productVarValuesToDelete = ProductVarValue::find()->where(['id' => $deletedIDs])->all();

        foreach ($productVarValuesToDelete as $varValueToDelete) {
            $deleted = $varValueToDelete->delete();
            if (!$deleted) {
                throw new Exception();
            }
        }
    }

    /**
     * Action neccessary for VarManagerWidget - appending one variable value at the end of the list.
     * @param Model $id - id of Var
     * @param string $type - type of VarValue
     * @return string - call of VarManagerWidget method for rendering view of VarValue.
     */
    public function actionAppendVarValue($id, $type)
    {
        $type = str_replace('-', '\\', $type);  // '-' from url get parameter changed to backslashes.
        $varValue = new ProductVarValue();
        $varValue->var_id = $id;

        return (new VarManagerWidget())->appendVariableValue($varValue);
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
