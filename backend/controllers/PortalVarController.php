<?php

namespace backend\controllers;

use backend\components\IdentifierComponent;
use backend\models\PortalVar;
use common\components\Alert;
use Exception;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;


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
    /**
     * Updates an existing Language model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id = null)
    {
        $model = $id ? $this->findModel($id) : new PortalVar();

        if ($model->load(Yii::$app->request->post())) {

            $transaction = Yii::$app->db->beginTransaction();
            try {

                if (Yii::$app->request->isAjax) { // ajax validácia
                    $transaction->rollBack();
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }

                if (!($model->validate() && $model->save())) {
                    throw new Exception;
                }

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
     * Deletes an existing PortalVar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {
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
