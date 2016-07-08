<?php

namespace backend\controllers;

use backend\models\Redirect;
use backend\models\search\RedirectSearch;
use common\components\Alert;
use Yii;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * RedirectController implements the CRUD actions for Redirect model.
 */
class RedirectController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Redirect models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RedirectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Redirect model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id = null)
    {
        $model = $id ? $this->findModel($id) : new Redirect();

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) { // ajax validácia
                return $this->ajaxValidation($model);
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (!($model->validate() && $model->save())) {
                    throw new Exception;
                }

                $transaction->commit();
                return $this->redirectAfterSave($model);
            } catch (Exception $exc) {
                $transaction->rollBack();
                $this->redirectAfterFail($model);
            }
        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Redirect model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {
            Alert::success('Položka bola úspešne zmazaná.');
        } else {
            Alert::danger('Vyskytla sa chyba pri vymazaní položky.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Redirect model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Redirect the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Redirect::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Požadovaná stránka neexistuje.');
        }
    }
}
