<?php

namespace backend\controllers;

use common\components\Alert;
use Exception;
use Yii;
use backend\models\Tag;
use backend\models\search\TagSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * TagController implements the CRUD actions for Tag model.
 */
class TagController extends BaseController
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
     * Lists all Tag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Tag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id = null)
    {
        $model = $id ? $this->findModel($id) : new Tag();

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) { // ajax validácia
                return $this->ajaxValidation($model);
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $productTypeIdsArray = Yii::$app->request->post('product_type_ids');
                $productTypesIds = !$productTypeIdsArray ?: implode($productTypeIdsArray, ',');
                $model->product_type = $productTypesIds;

                if (!($model->validate() && $model->save())) {
                    throw new Exception;
                }

                $model->updateProducts();

                $transaction->commit();

                return $this->redirectAfterSave($model);
            } catch (Exception $exception) {
                $transaction->rollBack();
                return $this->redirectAfterFail($model);
            }
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {
            Alert::success('Položka bola úspešne vymazaná.');
        } else {
            Alert::danger('Vyskytla sa chyba pri vymazávaní položky.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tag::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Požadovaná stránka neexistuje.');
        }
    }
}
