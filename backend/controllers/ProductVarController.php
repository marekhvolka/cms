<?php

namespace backend\controllers;

use backend\models\ProductVar;
use common\components\Alert;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * ProductVariableController implements the CRUD actions for ProductVar model.
 */
class ProductVarController extends BaseController
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
     * Lists all ProductVar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ProductVar::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing ProductVar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id = null)
    {
        if ($id) {
            $model = $this->findModel($id);
        } else {
            $model = new ProductVar();
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {

                $productTypeIdsArray = Yii::$app->request->post('product_type_ids');
                $productTypesIds = !$productTypeIdsArray ?: implode($productTypeIdsArray, ',');
                $model->product_type = $productTypesIds;

                if ($model->load(Yii::$app->request->post())) {
                    if ($model->save()) {
                        Alert::success('Položka bola úspešne uložená.');
                        return $this->redirect(Url::current());
                    } else {
                        Alert::danger('Vyskytla sa chyba pri ukladaní položky.');
                    }
                }
            } else {
                Alert::danger('Vyskytla sa chyba pri ukladaní položky.');
            }
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProductVar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete()){
            Alert::success('Položka bola úspešne vymazaná.');
        } else {
            Alert::danger('Vyskytla sa chyba pri vymazávaní položky.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductVar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductVar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductVar::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Požadovaná stránka neexistuje.');
        }
    }
}
