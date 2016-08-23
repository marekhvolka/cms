<?php

namespace backend\controllers;

use backend\models\search\WordSearch;
use backend\models\Word;
use common\components\Alert;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * WordController implements the CRUD actions for Word model.
 */
class WordController extends BaseController
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
     * Lists all Word models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Word model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionEdit($id = null)
    {
        $model = $id ? $this->findModel($id) : new Word();

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax && !Yii::$app->request->post('ajaxSubmit')) { // ajax validácia
                return $this->ajaxValidation($model);
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                Model::loadMultiple($model->translations, Yii::$app->request->post());

                if (!$model->validate() || !$model->save() || !Model::validateMultiple($model->translations)) {
                    throw new Exception();
                }

                foreach ($model->translations as $translation) {
                    $translation->word_id = $model->id;
                    $translation->save();
                }

                $transaction->commit();

                $model->resetAfterUpdate();

                return $this->redirectAfterSave($model);
            } catch (Exception $exc) {
                $transaction->rollBack();
                return $this->redirectAfterFail($model);
            }
        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Word model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Word the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Word::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Požadovaná stránka neexistuje.');
        }
    }
}