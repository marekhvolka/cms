<?php

namespace backend\controllers;

use backend\models\ProductVar;
use backend\models\ProductVarValue;
//use MongoDB\Driver\Exception\Exception;
use yii\base\Exception;
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

        if ($model->load(Yii::$app->request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();

            try {

                $productVarValuesData = Yii::$app->request->post('ProductVarValue');
                $productVarValues = []; // Array of ProductVarValue models used later for multiple validation.

                // $productVarValues array appended with retrieved newly created ProductVarValue models.
                foreach ($productVarValuesData as $i => $productValueData) {
                    $productVarValue = new ProductVarValue();
                    $productVarValues[$i] = $productVarValue;
                }

                // Product model validated and saved.
                $modelValidatedAndSaved = $model->validate() && $model->save();
                // ProductVarValue models multiple loading and validation.
                $loaded = Model::loadMultiple($productVarValues, Yii::$app->request->post());
                $valid = Model::validateMultiple($productVarValues);

                if (!$loaded || !$valid || !$modelValidatedAndSaved) {
                    throw new Exception;
                }

                $this->saveProductVarValues($productVarValues, $model);// Save ProductVarValue models.

                $transaction->commit();// There was no error, models was validated and saved correctly.
                return $this->redirect(['index']);
            } catch (Exception $e) {
                // There was problem with validation or saving models or another exception was thrown.
                $transaction->rollBack();
                return $this->render('create', [
                            'model' => $model,
                            'productVarValues' => (empty($productVarValues)) ?
                                    [] : $productVarValues,
                            'allVariables' => ProductVar::find()->all(),
                ]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'productVarValues' => $productVarValues,
                        'allVariables' => ProductVar::find()->all(),
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
        $model = $this->findModel($id); // Product model retrieved by id.
        $productVarValues = $model->productVarValues;

        if ($model->load(Yii::$app->request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();

            try {
                $productVarValuesData = Yii::$app->request->post('ProductVarValue');
                $productVarValues = []; // Array of ProductVarValue models used later for multiple validation.
                // $productVarValues array appended with retrieved existing ProductVarValue 
                // models or with newly created ones.
                foreach ($productVarValuesData as $i => $productValueData) {
                    // If 'existing' flag is true, ProductVarValue model is retrieved.
                    if ($productValueData['existing'] == 'true') {
                        $productVarValue = ProductVarValue::find()
                                ->where(['id' => $productValueData['id']])
                                ->one();
                    } else {
                        $productVarValue = new ProductVarValue();
                    }
                    $productVarValues[$i] = $productVarValue;
                }

                // Product model validated and saved.
                $modelValidatedAndSaved = $model->validate() && $model->save();
                // ProductVarValue models multiple loading and validation.
                $loaded = Model::loadMultiple($productVarValues, Yii::$app->request->post());
                $valid = Model::validateMultiple($productVarValues);

                if (!$loaded || !$valid || !$modelValidatedAndSaved) {
                    throw new Exception;
                }
                
                $this->saveProductVarValues($productVarValues, $model);// Save ProductVarValue models.
                $this->deleteProductVarValues($productVarValues, $model);// Delete ProductVarValue models.

                $transaction->commit(); // There was no error, models was validated and saved correctly.
                return $this->redirect(['index']);
            } catch (Exception $e) {
                // There was problem with validation or saving models or another exception was thrown.
                $transaction->rollBack();
                return $this->render('update', [
                            'model' => $model,
                            'productVarValues' => (empty($productVarValues)) ?
                                    [] : $productVarValues,
                            'allVariables' => ProductVar::find()->all(),
                ]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'productVarValues' => (empty($productVarValues)) ? [] : $productVarValues,
                        'allVariables' => ProductVar::find()->all(),
            ]);
        }
    }

    private function saveProductVarValues($productVarValues, $model)
    {
        // Each ProductVarValue model saved individually.
        foreach ($productVarValues as $productVarValue) {
            $productVarValue->product_id = $model->id;
            if (!$productVarValue->save()) {
                throw new Exception;
            }
        }
    }

    private function deleteProductVarValues($productVarValues, $model)
    {
        // IDs of newly created or updated ProductVarValues.
        $newIDs = ArrayHelper::map($productVarValues, 'id', 'id');
        // IDs of all ProductVarValues with ProductVarValues which user deleted.
        $allProductVarValues = ProductVarValue::find()
                ->where(['product_id' => $model->id])
                ->all();
        $oldIDs = ArrayHelper::map($allProductVarValues, 'id', 'id');

        $deletedIDs = array_diff($oldIDs, $newIDs); // IDs of ProductVarValues to be delted.
        $productVarValuesToDelete = ProductVarValue::find()->where(['id' => $deletedIDs])->all();

        // Deleting ProductVarValues.
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
