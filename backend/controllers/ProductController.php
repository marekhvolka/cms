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
use backend\components\VarManager\VarManagerWidget;

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

        $products = $searchModel->search(Yii::$app->request->queryParams, true)
            ->andWhere('parent_id IS NULL')
            ->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'products' => $products,
        ]);
    }

    /**
     * Edits an Product model.
     * If edit is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id = null)
    {
        if ($id) {
            $model = $this->findModel($id); // Product model retrieved by id.
        }
        else {
            $model = new Product();
        }

        if ($model->load(Yii::$app->request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();

            try {
                $productVarValuesData = Yii::$app->request->post('Var');

                if (!($model->validate() && $model->save()))
                    throw new Exception;

                foreach ($productVarValuesData as $index => $productValueData) {
                    $model->loadFromData('productVarValues', $productValueData, $index, ProductVarValue::className());
                }

                foreach($model->productVarValues as $productVarValue) {
                    $productVarValue->product_id = $model->id;
                    if (!($productVarValue->validate() && $productVarValue->save()))
                        throw new Exception;
                }

                $transaction->commit(); // There was no error, models was validated and saved correctly.

                $model->resetAfterUpdate();

                return $this->redirect(['index']);
            } catch (Exception $e) {
                // There was problem with validation or saving models or another exception was thrown.
                $transaction->rollBack();
                return $this->render('edit', [
                    'model' => $model,
                    'allVariables' => ProductVar::find()->all(),
                ]);
            }
        } else {
            return $this->render('edit', [
                'model' => $model,
                'allVariables' => ProductVar::find()->all(),
            ]);
        }
    }

    /**
     * Action necessary for VarManagerWidget - appending one variable value at the end of the list.
     * @return string - call of VarManagerWidget method for rendering view of VarValue.
     */
    public function actionAppendVarValue()
    {
        $varValue = new ProductVarValue();
        $varValue->var_id = Yii::$app->request->post('varId');

        $model = null;
        $prefix = Yii::$app->request->post('prefix');

        $indexVar = rand(1000, 100000);

        return (new VarManagerWidget())->appendVariableValue($varValue, $prefix, $indexVar, $model);
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
