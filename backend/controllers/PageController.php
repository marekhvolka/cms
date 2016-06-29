<?php

namespace backend\controllers;

use backend\models\Page;
use backend\models\search\PageSearch;
use common\components\DataEngine;
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
     * @param bool $duplicate
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionEdit($id = null, $duplicate = false)
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

            if ($duplicate) {
                $model = new Page();
                $model->portal_id = Yii::$app->session->get('portal_id');
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {

                $model->load(Yii::$app->request->post());

                $headerData = Yii::$app->request->post('headerSection');

                if ($headerData != null) {
                    $this->loadLayout($model, $headerData, 'headerSections');
                }

                $footerData = Yii::$app->request->post('footerSection');

                if ($footerData != null) {
                    $this->loadLayout($model, $footerData, 'footerSections');
                }

                $contentData = Yii::$app->request->post('contentSection');

                if ($contentData != null) {
                    $this->loadLayout($model, $contentData, 'contentSections');
                }

                $sidebarData = Yii::$app->request->post('sidebarSection');

                if ($sidebarData != null) {
                    $this->loadLayout($model, $sidebarData, 'sidebarSections');
                }

                if (!($model->validate() && $model->save()))
                    throw new Exception;

                $this->saveLayout($model, 'headerSections', 'page');
                $this->saveLayout($model, 'footerSections', 'page');
                $this->saveLayout($model, 'sidebarSections', 'page');
                $this->saveLayout($model, 'contentSections', 'page');

                $transaction->commit();

                $continue = Yii::$app->request->post('continue');

                if (isset($continue)) {
                    return $this->redirect(['edit', 'id' => $model->id]);
                } else {
                    return $this->redirect(['index']);
                }
            } catch (Exception $exc) {
                $transaction->rollBack();

                return $this->render('edit', [
                    'model' => $model
                ]);
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
        $cacheEngine = new DataEngine();

        $cacheEngine->init();

        $path = Page::findOne(['id' => $id])->getMainCacheFile();

        echo file_get_contents($path);
    }
}
