<?php

namespace backend\controllers;

use backend\models\Language;
use backend\models\PageBlock;
use backend\models\Portal;
use backend\models\Product;
use common\components\CacheEngine;
use common\components\ParseEngine;
use Yii;
use backend\models\Page;
use backend\models\search\PageSearch;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends BaseController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, true);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Page();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
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

    public function actionGenerate()
    {
        $cacheEngine = new CacheEngine();

        $cacheEngine->init();

        //$cacheEngine->cacheDictionary(Language::findOne(['identifier' => 'cz']));

        //$cacheEngine->createProductFile(Language::findOne(['identifier' => 'cz']));

        /*$products = Product::find()->all();

        foreach($products as $product)
            $cacheEngine->cacheProduct($product);

        $cacheEngine->compileBlock(PageBlock::findOne(['id' => 2050]));*/

        //$cacheEngine->cachePortal(Portal::findOne(['domain' => 'hyperfinance.cz']));

        $cacheEngine->cachePage(Page::findOne(['identifier' => 'pujcky']));
        $cacheEngine->compilePage(Page::findOne(['identifier' => 'pujcky']));
    }

    public function actionParse()
    {
        $parseEngine = new ParseEngine();

        $parseEngine->parseMasterContent();

        die();

        $parseEngine->parsePageGlobalSection('page_header', 'page');
        $parseEngine->parsePageGlobalSection('page_footer', 'page');

        $parseEngine->parsePageGlobalSection('portal_global', 'portal');
    }
}
