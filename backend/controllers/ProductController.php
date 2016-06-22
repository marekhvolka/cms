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

        $products = $searchModel->search(Yii::$app->request->queryParams)
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
            $productVarValues = $model->getProductProperties();
        }
        else {
            $model = new Product();
            $productVarValues = [];
        }

        if ($model->load(Yii::$app->request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();

            try {
                $productVarValuesData = Yii::$app->request->post('Var');

                if (!($model->validate() && $model->save()))
                    throw new Exception;

                foreach ($productVarValuesData as $index => $productValueData) {
                    ProductVarValue::loadFromData($productVarValues, $productValueData, $index, ProductVarValue::className());
                    $productVarValues[$index]->product_id = $model->id;
                }

                foreach($productVarValues as $productVarValue) {
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
                    'productVarValues' => $productVarValues,
                    'allVariables' => ProductVar::getProductVarProperties(),
                ]);
            }
        } else {
            return $this->render('edit', [
                'model' => $model,
                'productVarValues' => $productVarValues,
                'allVariables' => ProductVar::getProductVarProperties(),
            ]);
        }
    }

    /**
     * Action necessary for VarManagerWidget - appending one variable value at the end of the list.
     * @param Model $varId - id of Var
     * @return string - call of VarManagerWidget method for rendering view of VarValue.
     */
    public function actionAppendVarValue($varId)
    {
        $varValue = new ProductVarValue();
        $varValue->var_id = $varId;

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
