<?php

namespace backend\controllers;

use backend\components\VarManager\VarManagerWidget;
use backend\models\Block;
use backend\models\Model;
use backend\models\Product;
use backend\models\ProductVar;
use backend\models\ProductVarValue;
use backend\models\search\ProductSearch;
use common\components\Alert;
use Yii;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

//use MongoDB\Driver\Exception\Exception;

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
        $model = $id ? $this->findModel($id) : new Product();
        $allVariables = ProductVar::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) { // ajax validácia
                return $this->ajaxValidation($model);
            }
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (!($model->validate() && $model->save())) {
                    throw new Exception;
                }

                $productVarValuesData = Yii::$app->request->post('Var');

                foreach ($productVarValuesData as $index => $productValueData) {
                    $model->loadFromData('productVarValues', $productValueData, $index, ProductVarValue::className());

                    if (!key_exists('SnippetVarValue', $productValueData)) {
                        continue;
                    }

                    $model->productVarValues[$index]->setOutdated();

                    if (!$model->productVarValues[$index]->valueBlock) {
                        $block = new Block();
                        $block->type = 'snippet';
                        $block->product_var_value_id = $model->productVarValues[$index]->id;

                        $model->productVarValues[$index]->valueBlock = $block;
                    }

                    $model->productVarValues[$index]->valueBlock->snippet_code_id = $productValueData['snippet_code_id'];

                    $this->loadSnippetVarValues($productValueData, $model->productVarValues[$index]->valueBlock);
                }

                foreach ($model->productVarValues as $indexProductVarValue => $productVarValue) {
                    $productVarValue->product_id = $model->id;

                    if ($productVarValue->removed) {
                        $productVarValue->delete();
                        unset($model->productVarValues[$indexProductVarValue]);
                    }

                    if (!($productVarValue->validate() && $productVarValue->save())) {
                        throw new Exception;
                    }

                    if ($productVarValue->valueBlock) {
                        if (!($productVarValue->valueBlock->validate() && $productVarValue->valueBlock->save())) {
                            throw new Exception;
                        }

                        if ($productVarValue->valueBlock->isChanged()) {
                            $this->saveSnippetVarValues($productVarValue->valueBlock);
                        }
                    }
                }

                $transaction->commit(); // There was no error, models was validated and saved correctly.

                $model->resetAfterUpdate();

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
        $model = $this->findModel($id);
        if ($model->getProducts()->count() == 0) {
            $model->delete();
        } else {
            Alert::danger('Nemôžete vymazať stránku, ktorá obsahuje podstánky.');
        }

        $model->delete();

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
