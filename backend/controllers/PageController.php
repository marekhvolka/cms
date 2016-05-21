<?php

namespace backend\controllers;

use backend\models\Language;
use backend\models\Block;
use backend\models\Portal;
use backend\models\Product;
use backend\models\Section;
use backend\models\Snippet;
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
        return array_merge(parent::behaviors(),[
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, true);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex2()
    {
        $searchModel = new PageSearch();

        $pages = Page::findAll([
            'portal_id' => Yii::$app->session->get('portal_id'),
            'parent_id' => NULL
        ]);

        return $this->render('index2', [
            'pages' => $pages,
            'searchModel' => $searchModel
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

        $headerSections = [new Section()];
        $footerSections = [new Section()];
        $contentSections = [new Section()];
        $sidebarSections = [new Section()];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'headerSections' => $headerSections,
                'footerSections' => $footerSections,
                'contentSections' => $contentSections,
                'sidebarSections' => $sidebarSections,
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

        $headerSections = Section::findAll([
            'type' => 'header',
            'page_id' => $id
        ]);

        $footerSections = Section::findAll([
            'type' => 'footer',
            'page_id' => $id
        ]);

        $contentSections = Section::findAll([
            'type' => 'content',
            'page_id' => $id
        ]);

        $sidebarSections = Section::findAll([
            'type' => 'sidebar',
            'page_id' => $id
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'headerSections' => $headerSections,
                'footerSections' => $footerSections,
                'contentSections' => $contentSections,
                'sidebarSections' => $sidebarSections,
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

        $languages = Language::find()->all();

        /*foreach ($languages as $language)
        {
            $cacheEngine->createLanguageCacheDirectory($language);
            $cacheEngine->cacheDictionary($language);
            $cacheEngine->createProductsMainCacheFile($language);
        }*/

        /*$products = Product::find()->all();

        foreach($products as $product)
        {
            $product->getMainFile();
        }*/

        /*$portals = Portal::find()->all();

        foreach($portals as $portal)
        {
            $cacheEngine->cachePortal($portal);

            foreach($portal->pages as $page)
            {
                $cacheEngine->cachePage($page);
            }
        }*/

        /*$snippets = Snippet::find()->all();

        foreach($snippets as $snippet)
        {
            $snippet->getMainFile();

            foreach($snippet->snippetCodes as $code)
            {
                $code->getMainFile();
            }
        }*/


        //$cacheEngine->cachePortal(Portal::findOne(['domain' => 'hyperfinance.cz']));

        //$cacheEngine->compileBlock(Block::findOne(['id' => 2050]));

        //$cacheEngine->cachePageVars(Page::findOne(['id' => '356']));

        //$string = Page::findOne(['id' => '356'])->getMainCacheFile();

        //echo file_get_contents($string);

    }

    public function actionParse()
    {
        $parseEngine = new ParseEngine();

        $transaction = Yii::$app->db->beginTransaction();

        //$parseEngine->parseSnippetVarValues();

        //die();

        //$parseEngine->parseMasterContent();

        //$parseEngine->parsePageGlobalSection('page_header', 'page');
        //$parseEngine->parsePageGlobalSection('page_footer', 'page');

        $parseEngine->parsePageGlobalSection('portal_global', 'portal');

        $transaction->commit();
    }
}
