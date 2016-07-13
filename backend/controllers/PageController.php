<?php

namespace backend\controllers;

use backend\models\Area;
use backend\models\Page;
use backend\models\search\PageSearch;
use backend\models\Section;
use common\components\Alert;
use Yii;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends BaseController
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
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PageSearch();

        $pages = $searchModel->search(Yii::$app->request->queryParams, true)
            ->andWhere('parent_id IS NULL')
            ->all();

        return $this->render('index', [
            'pages' => $pages,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param bool $duplicate
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionEdit($id = null, $duplicate = false)
    {
        if ($id) {
            $model = $this->findModel($id);
        } else {
            $model = new Page();

            $model->initializeNew();
        }

        if (Yii::$app->request->isPost) {

            if ($duplicate) {
                $model = new Page();

                $model->initializeNew();
            }

            $model->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax) { // ajax validácia
                return $this->ajaxValidation($model);
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {

                $headerData = Yii::$app->request->post('header');
                $model->header->load($headerData);
                $this->loadLayout($model->header, $headerData);

                $footerData = Yii::$app->request->post('footer');
                $model->footer->load($footerData);
                $this->loadLayout($model->footer, $footerData);

                $contentData = Yii::$app->request->post('content');
                $model->content->load($contentData);
                $this->loadLayout($model->content, $contentData);

                $sidebarData = Yii::$app->request->post('sidebar');
                $model->sidebar->load($sidebarData);
                $this->loadLayout($model->sidebar, $sidebarData);

                if (!($model->validate() && $model->save())) {
                    throw new Exception;
                }

                $model->header->page_id = $model->id;
                $model->footer->page_id = $model->id;
                $model->content->page_id = $model->id;
                $model->sidebar->page_id = $model->id;

                $this->saveLayout($model->header);
                $this->saveLayout($model->footer);
                $this->saveLayout($model->sidebar);
                $this->saveLayout($model->content);

                $transaction->commit();

                $model->resetAfterUpdate();

                return $this->redirectAfterSave($model);
            } catch (Exception $exc) {
                $transaction->rollBack();

                return $this->redirectAfterFail($model);
            }
        }

        if ($duplicate) {
            $model->prepareToDuplicate();
        }
        return $this->render('edit', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->getPages()->count() == 0) {
            $model->delete();
        } else {
            Alert::danger('Nemôžete vymazať stránku, ktorá obsahuje podstránky.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionShow($id)
    {
        $page = $this->findModel($id);

        Yii::$app->session->set('portal_preview', $page->portal->id);

        return $this->redirect('http://www.' . $page->portal->domain . $page->getUrl());
    }
}
