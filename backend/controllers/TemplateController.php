<?php

namespace backend\controllers;

use backend\components\FileEditor\FileEditorWidget;
use common\components\Alert;
use Yii;
use backend\models\Template;
use backend\models\search\TemplateSearch;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TemplateController implements the CRUD actions for Template model.
 */
class TemplateController extends BaseController
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
     * Lists all Template models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Template model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id = null)
    {
        if ($id) {
            $model = $this->findModel($id);
        } else {
            $model = new Template();
        }

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                Alert::success('Položka bola úspešne uložená.');
                return $this->redirect(Url::current());
            } else {
                Alert::danger('Vyskytla sa chyba pri ukladaní položky.');
            }
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    public function actionEditFiles($id)
    {
        $template = $this->findModel($id);

        /**
         * @var $file_editor FileEditorWidget
         */
        $file_editor = Yii::createObject([
            'class' => FileEditorWidget::className(),
            'directory' => $template->getMainDirectory(),
            'generatedUrlPrefix' => '{$portal->template|escapeUrl}'
        ]);
        $state = $file_editor->performActions();

        if ($state === false) {
            return $this->render('edit-files', [
                'template' => $template,
                'fileEditor' => $file_editor
            ]);
        } else {
            return $state;
        }
    }

    /**
     * Deletes an existing Template model.
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
     * Finds the Template model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Template the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Template::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Požadovaná stránka neexistuje.');
        }
    }
}
