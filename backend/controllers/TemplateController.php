<?php

namespace backend\controllers;

use backend\components\FileEditor\FileEditorWidget;
use backend\models\search\TemplateSearch;
use backend\models\Template;
use common\components\Alert;
use Exception;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

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
        $model = $id ? $this->findModel($id) : new Template();

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

    public function actionEditFiles($id)
    {
        $template = $this->findModel($id);

        /**
         * @var $file_editor FileEditorWidget
         */
        $file_editor = Yii::createObject([
            'class' => FileEditorWidget::className(),
            'directory' => $template->getMainDirectory(),
            'generatedUrlPrefix' => '{$portal->template}'
        ]);
        $state = $file_editor->performActions();

        if ($state === false) {
            return $this->render('edit-files', [
                'model' => $template,
                'fileEditor' => $file_editor
            ]);
        } else {
            return $state;
        }
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
