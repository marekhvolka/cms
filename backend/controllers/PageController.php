<?php

namespace backend\controllers;

use backend\models\Page;
use backend\models\search\PageSearch;
use backend\models\Section;
use common\components\CacheEngine;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends BaseController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class'   => VerbFilter::className(),
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
            'pages'       => $pages,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id = null)
    {
        $headerSections = Section::findAll([
            'type' => 'header',
            'page_id' => $id ? $id : -1
        ]);

        $footerSections = Section::findAll([
            'type' => 'footer',
            'page_id' => $id ? $id : -1
        ]);

        $contentSections = Section::findAll([
            'type' => 'content',
            'page_id' => $id ? $id : -1
        ]);

        $sidebarSections = Section::findAll([
            'type' => 'sidebar',
            'page_id' => $id ? $id : -1
        ]);

        if ($id) {
            $model = $this->findModel($id);
        }
        else {
            $model = new Page();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('edit', [
                'model' => $model,
                'headerSections' => $headerSections,
                'footerSections' => $footerSections,
                'sidebarSections' => $sidebarSections,
                'contentSections' => $contentSections,
            ]);
        }
    }

    /**
     * Deletes an existing Page model.
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

    public function actionGenerate($id)
    {
        $cacheEngine = new CacheEngine();

        $cacheEngine->init();

        $path = Page::findOne(['id' => $id])->getMainCacheFile();

        echo file_get_contents($path);
    }
}
