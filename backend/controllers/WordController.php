<?php

namespace backend\controllers;

use backend\models\Language;
use backend\models\Word;
use backend\models\WordTranslation;
use backend\models\search\WordSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * WordController implements the CRUD actions for Word model.
 */
class WordController extends BaseController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(),[
            'verbs' => [
                'class'   => VerbFilter::className(),
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
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Word model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Word();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $translations = Yii::$app->request->post()['translation'];
            /** @var WordTranslation[] $original_translations */
            $original_translations = $model->getTranslations()->indexBy('language_id')->all();
            $this->saveTranslations($original_translations, $translations, $model);

            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'languages' => Language::find()->all(),
                'defaultLanguage' => Language::findOne(['identifier' => 'sk'])
            ]);
        }
    }

    /**
     * Updates an existing Word model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $translations = Yii::$app->request->post()['translation'];

            /** @var WordTranslation[] $original_translations */
            $original_translations = $model->getTranslations()->indexBy('language_id')->all();

            $this->saveTranslations($original_translations, $translations, $model);

            return $this->redirect(['update', 'id' => $id]);
        } else {
            $lang = Language::findOne(['identifier' => 'sk']);

            return $this->render('update', [
                'model' => $model,
                'languages' => Language::find()->all(),
                'defaultLanguage' => Language::findOne(['identifier' => 'sk'])
            ]);
        }
    }

    private function saveTranslations($original_translations, $new_translations, $of_word)
    {
        foreach ($new_translations as $lang_id => $new_translation) {
            if (!empty($new_translation)) {
                if (!isset($original_translations[$lang_id])) {
                    $new_translation_object = new WordTranslation();
                    $new_translation_object->language_id = $lang_id;
                    $new_translation_object->word_id = $of_word->id;
                    $new_translation_object->translation = $new_translation;
                    $new_translation_object->save();
                } else {
                    if ($original_translations[$lang_id]->translation != $new_translation) {
                        $original_translations[$lang_id]->translation = $new_translation;
                        $original_translations[$lang_id]->save();
                    }
                }
            }
        }
    }

    /**
     * Deletes an existing Word model.
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
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
