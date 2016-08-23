<?php

namespace backend\controllers;

use backend\models\PostCategory;
use backend\models\search\PostCategorySearch;
use Exception;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * PostCategoryController implements the CRUD actions for PostCategory model.
 */
class PostCategoryController extends BaseController
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
     * Lists all PostCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new PostCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param null $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionEdit($id = null)
    {
        $model = $id ? $this->findModel($id) : new PostCategory();

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax && !Yii::$app->request->post('ajaxSubmit')) { // ajax validácia
                return $this->ajaxValidation($model);
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->validateAndSave();

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
     * Finds the PostCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PostCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PostCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
