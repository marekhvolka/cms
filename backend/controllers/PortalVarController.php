<?php

namespace backend\controllers;

use backend\models\PortalVar;
use common\components\Alert;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\IdentifierComponent;


/**
 * PortalVarController implements the CRUD actions for PortalVar model.
 */
class PortalVarController extends BaseController
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
     * Lists all PortalVar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PortalVar::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing PortalVar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id = null)
    {
        if ($id) {
            $model = $this->findModel($id);
        } else {
            $model = new PortalVar();
        }

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                Alert::success('Položka bola úspešne uložená.');

                return $this->redirect(Url::current());
            } else {
                Alert::danger('Položku sa nepodarilo vymazať.');
            }
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PortalVar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete()) {
            Alert::success('Položka bola úspešne vymazaná.');
        } else {
            Alert::danger('Položku sa nepodarilo vymazať.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the PortalVar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PortalVar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PortalVar::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Táto stránka neexistuje.');
        }
    }
}
