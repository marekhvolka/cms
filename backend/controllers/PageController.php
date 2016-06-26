<?php

namespace backend\controllers;

use backend\models\Page;
use backend\models\search\PageSearch;
use backend\models\Section;
use common\components\CacheEngine;
use common\components\ParseEngine;
use Yii;
use yii\base\Exception;
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
     * @return mixed
     */
    public function actionEdit($id = null)
    {
        if ($id) {
            $model = $this->findModel($id);

            if ($model->parsed == 0) {
                $parseEngine = new ParseEngine();
                $parseEngine->parsePage($model);
            }
        } else {
            $model = new Page();
        }

        if (Yii::$app->request->isPost) {

            $transaction = Yii::$app->db->beginTransaction();
            try {

                if (!($model->load(Yii::$app->request->post()) && $model->save())) {
                    throw new Exception;
                }

                $headerData = Yii::$app->request->post('headerSection');

                if ($headerData != null) {
                    $this->loadAndSaveLayout($model, $headerData, 'headerSections', 'page');
                }

                $footerData = Yii::$app->request->post('footerSection');

                if ($footerData != null) {
                    $this->loadAndSaveLayout($model, $footerData, 'footerSections', 'page');
                }

                $contentData = Yii::$app->request->post('contentSection');

                if ($contentData != null) {
                    $this->loadAndSaveLayout($model, $contentData, 'contentSections', 'page');
                }

                $sidebarData = Yii::$app->request->post('sidebarSection');

                if ($sidebarData != null) {
                    $this->loadAndSaveLayout($model, $sidebarData, 'sidebarSections', 'page');
                }

                $transaction->commit();
            } catch (Exception $exc) {
                $transaction->rollBack();

                return $this->render('edit', [
                    'model' => $model
                ]);
            }

            return $this->redirect(['index']);
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
