<?php

namespace backend\controllers;

use common\components\Alert;
use Yii;
use backend\models\TrackingCode;
use backend\models\search\TrackingCodeSearch;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TrackingCodeController implements the CRUD actions for TrackingCode model.
 */
class TrackingCodeController extends BaseController
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
     * Lists all TrackingCode models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TrackingCodeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing TrackingCode model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id = null)
    {
        if ($id) {
            $model = $this->findModel($id);
        } else {
            $model = new TrackingCode();
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->portal_id = Yii::$app->session->get('portal_id');
            if ($model->save()) {
                $model->portal->resetAfterUpdate();
                Alert::success('Položka bola úspešne uložená.');

                if (isset($continue)) {
                    return $this->redirect(['edit', 'id' => $model->id]);
                } else {
                    return $this->redirect(['index']);
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
     * Deletes an existing TrackingCode model.
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
     * Finds the TrackingCode model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TrackingCode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrackingCode::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Požadovaná stránka neexistuje.');
        }
    }
}
