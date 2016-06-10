<?php

namespace backend\controllers;

use backend\models\Language;
use backend\models\Word;
use backend\models\WordTranslation;
use backend\models\search\WordSearch;
use Yii;
use yii\base\Model;
use yii\filters\VerbFilter;
use yii\helpers\BaseVarDumper;
use yii\helpers\VarDumper;
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
        $translations = [];

        foreach(Language::find()->all() as $language)
        {
            $translation = new WordTranslation();
            $translation->language_id = $language->id;

            $translations[] = $translation;
        }

        if ($model->load(Yii::$app->request->post()))
        {
            Model::loadMultiple($translations, Yii::$app->request->post());

            $valid = $model->validate();
            $valid = Model::validateMultiple($translations) && $valid;

            if ($valid)
            {
                $model->save();

                foreach($translations as $translation)
                {
                    $translation->word_id = $model->id;

                    if ($translation->validate())
                    {
                        $translation->save();

                        Yii::$app->session->setFlash('success', 'Uložené');
                    }
                    else
                    {
                        BaseVarDumper::dump($translation->errors);
                        Yii::$app->session->setFlash('error', 'Nastala chyba');
                    }
                }
            }
            else
                BaseVarDumper::dump($model->errors);

            $continue = Yii::$app->request->post('continue');

            if (isset($continue))
                return $this->redirect(['update', 'id' => $model->id]);
            else
                return $this->redirect(['index']);
        }
        else
        {
            return $this->render('create', [
                'model' => $model,
                'translations' => $translations
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
        $translations = $model->translations;

        //TODO: dokoncit funkcionalitu pri pridani noveho jazyka

        if ($model->load(Yii::$app->request->post()))
        {
            Model::loadMultiple($translations, Yii::$app->request->post());

            $valid = $model->validate();
            $valid = Model::validateMultiple($translations) && $valid;

            if ($valid)
            {
                $model->save();

                foreach($translations as $translation)
                {
                    $translation->save();
                }

                Yii::$app->session->setFlash('success', 'Uložené');
            }
            else
            {
                Yii::$app->session->setFlash('error', 'Nastala chyba');
            }

            $continue = Yii::$app->request->post('continue');

            if (isset($continue))
                return $this->redirect(['update', 'id' => $model->id]);
            else
                return $this->redirect(['index']);
        }
        else
        {
            return $this->render('update', [
                'model' => $model,
                'translations' => $model->translations,
            ]);
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
