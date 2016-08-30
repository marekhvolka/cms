<?php

namespace backend\controllers;

use Exception;
use Yii;
use backend\models\Post;
use backend\models\search\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends BaseController
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
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, true);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param bool $duplicate
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function actionEdit($id = null, $duplicate = false)
    {
        if ($id) {
            $model = $this->findModel($id);
        } else {
            $model = new Post();
            $model->initializeNew();
        }

        if (Yii::$app->request->isPost) {

            if ($duplicate) {
                $model = new Post();
                $model->initializeNew();
            }

            $model->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax && !Yii::$app->request->post('ajaxSubmit')) { // ajax validácia
                return $this->ajaxValidation($model);
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $headerData = Yii::$app->request->post('header');
                $model->header->load($headerData, '');
                $this->loadLayout($model->header, $headerData);

                $footerData = Yii::$app->request->post('footer');
                $model->footer->load($footerData, '');
                $this->loadLayout($model->footer, $footerData);

                $contentData = Yii::$app->request->post('content');
                $model->content->load($contentData, '');
                $this->loadLayout($model->content, $contentData);

                $sidebarData = Yii::$app->request->post('sidebar');
                $model->sidebar->load($sidebarData, '');
                $this->loadLayout($model->sidebar, $sidebarData);

                $model->validateAndSave();

                $model->header->post_id = $model->id;
                $model->footer->post_id = $model->id;
                $model->content->post_id = $model->id;
                $model->sidebar->post_id = $model->id;

                $this->saveLayout($model->header);
                $this->saveLayout($model->footer);
                $this->saveLayout($model->sidebar);
                $this->saveLayout($model->content);

                $model->updateTags();

                $transaction->commit();

                $model->resetAfterUpdate();

                if (!$id || $duplicate) { //ak sa jednalo o vytvaranie produktu, tak resetneme subor so zoznamom produktov
                    $model->portal->getPortalPostsFile(true);
                }

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
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionShow($id)
    {
        $post = $this->findModel($id);

        if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') { //localhost
            $redirectPrefix = 'http://' . $_SERVER['HTTP_HOST'];
        } else {
            $redirectPrefix = 'http://www.' . $post->portal->domain;
        }

        return $this->redirect($redirectPrefix . '/' . $post->portal->blogMainPage->identifier . '/' . $post->identifier . '/');
    }
}
