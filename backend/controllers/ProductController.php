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
        $productVarValues = [new ProductVarValue()];

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $modelsProductVarValue = Model::createMultiple(ProductVarValue::classname());
            Model::loadMultiple($modelsProductVarValue, Yii::$app->request->post());
            
            // TODO - refactor this - same code in PortalController
            $vars = Yii::$app->request->post('var');
            foreach ($vars as $id_var => $value) {
                $productVarValue = new ProductVarValue();
                $productVarValue->product_id = $model->id;
                $productVarValue->var_id = $id_var;
                $productVarValue->value = $value[0];
                $productVarValue->save();
            }

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
                        $this->cacheEngine->cacheProduct($model);
                        return $this->redirect(['index']);
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
        $productVarValues = $model->productVarValues;

        $allVariables = ProductVar::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $editedProductVarValuesData = Yii::$app->request->post('ProductVarValue');
            
            foreach ($editedProductVarValuesData as $id => $productValueData) {
                if ($productValueData['existing'] == 'true') {
                    $productVarValue = ProductVarValue::find()->where(['id' => $id])->one();
                } else {
                    $productVarValue = new ProductVarValue();
                }
                
                $productVarValue->attributes = $productValueData;   
                $validated = $productVarValue->validate();
                if (!$validated) {
                    return;
                }
            }
            
            //$valid = $model->validate(); TODO validation
            
            $oldIDs = ArrayHelper::map($productVarValues, 'id', 'id');
            $newIDs = ArrayHelper::map($editedProductVarValuesData, 'id', 'id');
            
            $deletedIDs = array_diff($oldIDs, $newIDs);
            
            return;
            
            $vars = Yii::$app->request->post('var');
            
            foreach ($model->productVarValues as $var_value) {
                $var_value->delete();
            }
            
            
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsProductVarValue),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            

            $valid = Model::validateMultiple($modelsProductVarValue) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            ProductVar::deleteAll(['id' => $deletedIDs]);
                        }
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
                        $this->cacheEngine->cacheProduct($model);
                        return $this->redirect(['index']);
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
                'productVarValues' => (empty($productVarValues)) ? [new ProductVarValue()] : $productVarValues,
                'allVariables' => $allVariables
            ]);
        }
    }
    
    public function actionAppendVarValue($id, $type) 
    {
        $type = str_replace('-', '\\', $type);
        $varValue = new ProductVarValue();
        
        $varClassName = str_replace('Value', '', $type);
        
        $var = $varClassName::find()->where(['id' => $id])->one();
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
