<?php

namespace backend\controllers;

use backend\components\BlockModal\BlockModalWidget;
use backend\components\LayoutWidget\LayoutWidget;
use backend\components\MultimediaWidget\MultimediaWidget;
use backend\models\Area;
use backend\models\Block;
use backend\models\Column;
use backend\models\ListItem;
use backend\models\MultimediaCategory;
use backend\models\MultimediaItem;
use backend\models\Page;
use backend\models\Portal;
use backend\models\Post;
use backend\models\Row;
use backend\models\search\GlobalSearch;
use backend\models\Section;
use backend\models\Snippet;
use backend\models\SnippetCode;
use backend\models\SnippetVar;
use backend\models\SnippetVarValue;
use common\components\Alert;
use yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
 * WordController implements the CRUD actions for Word model.
 */
abstract class BaseController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ]
        ];
    }

    public function init()
    {
        parent::init();

        Yii::$app->session->setTimeout(3600 * 24 * 30);

        $change_portal = Yii::$app->request->get('change-portal');

        if (!empty($change_portal)) {
            $this->changeCurrentPortal($change_portal);
        }
    }

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest && $action->className() == yii\web\ErrorAction::className()) {
            Yii::$app->getResponse()->redirect(['site/login'])->send();
            die();
        }

        return parent::beforeAction($action);
    }

    public function changeCurrentPortal($portalId)
    {
        Yii::$app->user->identity->portal_id = $portalId;
        Yii::$app->user->identity->save();

        /* @var $portal Portal */
        $portal = Portal::findOne($portalId);

        if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') { //localhost
            $redirectPrefix = 'http://' . $_SERVER['HTTP_HOST'];
        } else {
            $redirectPrefix = 'http://www.' . $portal->domain;
        }

        $this->redirect($redirectPrefix . '/backend/web/');
    }

    /**
     * Returns the result of the global search as JSON.
     *
     * @param $q string the query to search by
     * @return array
     */
    public function actionGlobalSearchResults($q)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return (new GlobalSearch)->search($q);
    }

    public function actionMultimediaUpload()
    {
        $item = new MultimediaItem();
        $item->scenario = MultimediaItem::SCENARIO_UPLOAD;
        $item->load(Yii::$app->request->post());
        $item->files = UploadedFile::getInstances($item, 'files');
        $item->upload();

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            "state" => "ok",
            'path' => $item->path,
            'pathForWeb' => MultimediaCategory::fromPath($item->path)->pathForWeb
        ];
    }

    public function actionMultimediaRefresh()
    {
        return MultimediaWidget::widget(['onlyItems' => true]);
    }

    public function actionGetSnippetCodeVariables($id)
    {
        preg_match_all('/([a-zA-Z0-9_]+)->([a-zA-Z0-9_]+)/i', SnippetCode::findOne(['id' => $id])->code, $matches);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $matches[2];
    }

    /**
     * Action necessary for LayoutWidget - appending one section at the end of the list.
     * @return string - call of LayoutWidget method for rendering view.
     * @internal param string $type
     */
    public function actionAppendSection()
    {
        $prefix = Yii::$app->request->post('prefix');
        $layoutOwner = null;
        $layoutOwnerType = Yii::$app->request->post('layoutOwnerType');

        if ($layoutOwnerType == 'post') {
            $layoutOwner = Post::findOne(Yii::$app->request->post('layoutOwnerId'));
        } else if ($layoutOwnerType == 'page') {
            $layoutOwner = Page::findOne(Yii::$app->request->post('layoutOwnerId'));
        }

        $portal = Portal::findOne(Yii::$app->request->post('portalId'));

        $section = new Section();

        $indexSection = rand(1000, 10000000);

        return (new LayoutWidget())->appendSection($section, $prefix, $indexSection, $layoutOwner, $portal);
    }

    /**
     * Action necessary for LayoutWidget - appending one row at the end of the list.
     * @return string - call of LayoutWidget method for rendering view.
     */
    public function actionAppendRow()
    {
        $prefix = Yii::$app->request->post('prefix');

        $layoutOwner = null;
        $layoutOwnerType = Yii::$app->request->post('layoutOwnerType');

        if ($layoutOwnerType == 'post') {
            $layoutOwner = Post::findOne(Yii::$app->request->post('layoutOwnerId'));
        } else if ($layoutOwnerType == 'page') {
            $layoutOwner = Page::findOne(Yii::$app->request->post('layoutOwnerId'));
        }
        $portal = Portal::findOne(Yii::$app->request->post('portalId'));

        $row = new Row();

        $indexRow = rand(1000, 10000000);

        return (new LayoutWidget())->appendRow($row, $prefix, $indexRow, $layoutOwner, $portal);
    }

    public function actionAppendColumns()
    {
        $width = Yii::$app->request->post('width');
        $prefix = Yii::$app->request->post('prefix');

        $layoutOwner = null;
        $layoutOwnerType = Yii::$app->request->post('layoutOwnerType');
        $layoutOwnerId = Yii::$app->request->post('layoutOwnerId');

        if ($layoutOwnerType == 'post') {
            if (empty($layoutOwnerId)) {
                $layoutOwner = new Post();
                $layoutOwner->initializeNew();
            } else {
                $layoutOwner = Post::findOne($layoutOwnerId);
            }
        } else if ($layoutOwnerType == 'page') {
            if (empty($layoutOwnerId)) {
                $layoutOwner = new Page();
                $layoutOwner->initializeNew();
            } else {
                $layoutOwner = Page::findOne($layoutOwnerId);
            }
        }

        $portal = Portal::findOne(Yii::$app->request->post('portalId'));

        $columnsData = array();

        for ($i = 0; $i < sizeof($width); $i++) {
            $column = new Column();
            $column->order = $i + 1;
            $column->width = $width[$i];

            $indexColumn = rand(1000, 10000000);

            $columnsData[] = (new LayoutWidget())->appendColumn($column, $prefix, $indexColumn, $layoutOwner, $portal);
        }
        return json_encode($columnsData);
    }

    /**
     * Action necessary for LayoutWidget - appending one block at the end of the list.
     * @return string - call of LayoutWidget method for rendering view.
     */
    public function actionAppendBlock()
    {
        $prefix = Yii::$app->request->post('prefix');

        $layoutOwner = null;
        $layoutOwnerType = Yii::$app->request->post('layoutOwnerType');
        $layoutOwnerId = Yii::$app->request->post('layoutOwnerId');

        if ($layoutOwnerType == 'post') {
            if (empty($layoutOwnerId)) {
                $layoutOwner = new Post();
                $layoutOwner->initializeNew();
            } else {
                $layoutOwner = Post::findOne($layoutOwnerId);
            }
        } else if ($layoutOwnerType == 'page') {
            if (empty($layoutOwnerId)) {
                $layoutOwner = new Page();
                $layoutOwner->initializeNew();
            } else {
                $layoutOwner = Page::findOne($layoutOwnerId);
            }
        }

        $portal = Portal::findOne(Yii::$app->request->post('portalId'));

        $indexBlock = rand(1000, 1000000);

        $block = new Block();
        $block->type = Yii::$app->request->post('type');

        return (new LayoutWidget())->appendBlock($block, $prefix, $indexBlock, $layoutOwner, $portal);
    }

    public function actionAppendBlockModal()
    {
        $id = Yii::$app->request->post('id');
        $prefix = Yii::$app->request->post('prefix');
        $type = Yii::$app->request->post('type');

        $layoutOwner = null;
        $layoutOwnerType = Yii::$app->request->post('layoutOwnerType');
        $layoutOwnerId = Yii::$app->request->post('layoutOwnerId');

        if ($layoutOwnerType == 'post') {
            if (empty($layoutOwnerId)) {
                $layoutOwner = new Post();
                $layoutOwner->initializeNew();
            } else {
                $layoutOwner = Post::findOne($layoutOwnerId);
            }
        } else if ($layoutOwnerType == 'page') {
            if (empty($layoutOwnerId)) {
                $layoutOwner = new Page();
                $layoutOwner->initializeNew();
            } else {
                $layoutOwner = Page::findOne($layoutOwnerId);
            }
        }

        $portal = Portal::findOne(Yii::$app->request->post('portalId'));

        $block = Block::findOne(['id' => $id]);

        if (!$block) {
            $block = new Block();
            $block->type = $type;
        }

        return (new BlockModalWidget())->appendModal($block, $prefix, $layoutOwner, $portal);
    }

    public function actionAppendBlockModalContent()
    {
        $snippet = Snippet::findOne(Yii::$app->request->post('snippetId'));
        $parent = Block::findOne(Yii::$app->request->post('parentId'));

        $block = new Block();
        $block->type = Yii::$app->request->post('blockType');

        if ($snippet) {
            $block->snippet_code_id = $snippet->snippetCodes[0]->id;
        } else if ($parent) {
            $block->parent_id = $parent->id;
        }

        $layoutOwner = null;
        $layoutOwnerType = Yii::$app->request->post('layoutOwnerType');
        $layoutOwnerId = Yii::$app->request->post('layoutOwnerId');

        if ($layoutOwnerType == 'post') {
            if (empty($layoutOwnerId)) {
                $layoutOwner = new Post();
                $layoutOwner->initializeNew();
            } else {
                $layoutOwner = Post::findOne($layoutOwnerId);
            }
        } else if ($layoutOwnerType == 'page') {
            if (empty($layoutOwnerId)) {
                $layoutOwner = new Page();
                $layoutOwner->initializeNew();
            } else {
                $layoutOwner = Page::findOne($layoutOwnerId);
            }
        }

        $portal = Portal::findOne(Yii::$app->request->post('portalId'));
        $prefix = Yii::$app->request->post('prefix');

        return (new BlockModalWidget())->render('_snippet', [
            'model' => $block,
            'layoutOwner' => $layoutOwner,
            'portal' => $portal,
            'prefix' => $prefix
        ]);
    }

    public function actionAppendListItem()
    {
        $prefix = Yii::$app->request->post('prefix');

        $parentVarId = Yii::$app->request->post('parentVarId');

        $parentVar = SnippetVar::find()->where(['id' => $parentVarId])->one();

        $layoutOwner = null;
        $layoutOwnerType = Yii::$app->request->post('layoutOwnerType');
        $layoutOwnerId = Yii::$app->request->post('layoutOwnerId');

        if ($layoutOwnerType == 'post') {
            if (empty($layoutOwnerId)) {
                $layoutOwner = new Post();
                $layoutOwner->initializeNew();
            } else {
                $layoutOwner = Post::findOne($layoutOwnerId);
            }
        } else if ($layoutOwnerType == 'page') {
            if (empty($layoutOwnerId)) {
                $layoutOwner = new Page();
                $layoutOwner->initializeNew();
            } else {
                $layoutOwner = Page::findOne($layoutOwnerId);
            }
        }

        $portal = Portal::findOne(Yii::$app->request->post('portalId'));

        $parentId = Yii::$app->request->post('parentId');

        $listItem = $parentVar->createNewListItem();

        $indexItem = rand(1000, 10000);

        return (new BlockModalWidget())->appendListItem($listItem, $prefix, $indexItem, $layoutOwner, $portal, $parentId);
    }

    public function actionAppendMultimediaWindow()
    {
        return (new MultimediaWidget())->run();
    }

    /** Metoda na nacitanie a ulozenie dat pre layout
     * @param Area $model
     * @param $data
     * @throws \yii\base\Exception
     */
    public function loadLayout(Area $model, $data)
    {
        if (!key_exists('Section', $data)) {
            return;
        }

        $sectionOrderIndex = 1;
        foreach ($data['Section'] as $indexSection => $itemSection) {
            $itemSection['order'] = $sectionOrderIndex++;
            $model->loadFromData('sections', $itemSection, $indexSection, Section::className());

            if (!key_exists('Row', $itemSection)) {
                continue;
            }

            $section = $model->sections[$indexSection];

            $rowOrderIndex = 1;
            foreach ($itemSection['Row'] as $indexRow => $itemRow) {
                $itemRow['order'] = $rowOrderIndex++;
                $section->loadFromData('rows', $itemRow, $indexRow, Row::className());

                if (!key_exists('Column', $itemRow)) {
                    continue;
                }

                $row = $section->rows[$indexRow];
                $columnOrderIndex = 1;
                foreach ($itemRow['Column'] as $indexColumn => $itemColumn) {
                    $itemColumn['order'] = $columnOrderIndex++;
                    $row->loadFromData('columns', $itemColumn, $indexColumn, Column::className());

                    if (!key_exists('Block', $itemColumn)) {
                        continue;
                    }

                    $column = $row->columns[$indexColumn];
                    $blockOrderIndex = 1;
                    foreach ($itemColumn['Block'] as $indexBlock => $itemBlock) {
                        $itemBlock['order'] = $blockOrderIndex++;
                        $column->loadFromData('blocks', $itemBlock, $indexBlock, Block::className());

                        if (!key_exists('SnippetVarValue', $itemBlock)) {
                            continue;
                        }

                        $block = $column->blocks[$indexBlock];
                        $block->setOutdated();

                        $this->loadSnippetVarValues($itemBlock, $block);
                    }
                }
            }
        }
    }

    /** Metoda na ulozenie layoutu
     * @param Area $model - objekt, portal/podstranka
     * @throws Exception
     */
    public function saveLayout($model)
    {
        $model->validateAndSave();

        foreach ($model->sections as $indexSection => $section) {
            $section->area_id = $model->id;

            if ($section->removed) {
                $section->delete();
                unset($model->sections[$indexSection]);
                continue;
            }
            $section->validateAndSave();

            if ($section->isChanged()) {
                $model->setOutdated();
            }

            foreach ($section->rows as $indexRow => $row) {
                $row->section_id = $section->id;

                if ($row->removed) {
                    $row->delete();
                    unset($section->rows[$indexRow]);
                    continue;
                }

                $row->validateAndSave();

                if ($row->isChanged()) {
                    $model->setOutdated();
                }

                foreach ($row->columns as $indexColumn => $column) {
                    $column->row_id = $row->id;

                    if ($column->removed) {
                        $column->delete();
                        unset($row->columns[$indexColumn]);
                        continue;
                    }
                    $column->validateAndSave();

                    if ($column->isChanged()) {
                        $model->setOutdated();
                    }

                    foreach ($column->blocks as $indexBlock => $block) {
                        $block->column_id = $column->id;

                        if ($block->removed) {
                            $block->delete();
                            unset($column->blocks[$indexBlock]);
                            continue;
                        }
                        $block->validateAndSave();

                        if ($block->isChanged()) {
                            $model->setOutdated();
                        }

                        if ($block->isContentChanged()) {
                            $this->saveSnippetVarValues($block);
                            $block->resetAfterUpdate();
                        }
                    }
                }
            }
        }

        if ($model->outdated) {
            $model->getCacheFile(true);
        }
    }

    public function loadSnippetVarValues($data, $model)
    {
        foreach ($data['SnippetVarValue'] as $indexVar => $itemVarValue) {
            $model->loadFromData('snippetVarValues', $itemVarValue, $indexVar, SnippetVarValue::className());

            if (key_exists('ListItem', $itemVarValue)) {
                $list = $model->snippetVarValues[$indexVar];

                $listItemOrderIndex = 1;
                foreach ($itemVarValue['ListItem'] as $indexListItem => $itemList) {
                    $itemList['order'] = $listItemOrderIndex++;
                    $list->loadFromData('listItems', $itemList, $indexListItem, ListItem::className());

                    if (key_exists('SnippetVarValue', $itemList)) {
                        $this->loadSnippetVarValues($itemList, $list['listItems'][$indexListItem]);
                    }
                }
            }
        }
    }

    public function saveSnippetVarValues($model, $type = 'block')
    {
        /* @var $snippetVarValue SnippetVarValue */
        foreach ($model->snippetVarValues as $snippetVarValue) {
            if ($type == 'block') {
                $snippetVarValue->block_id = $model->id;
            } else if ($type == 'list') {
                $snippetVarValue->list_item_id = $model->id;
            }

            $snippetVarValue->validateAndSave();

            /* @var $listItem ListItem */
            foreach ($snippetVarValue->listItems as $indexListItem => $listItem) {
                if ($listItem->removed) {
                    $listItem->delete();
                    unset($snippetVarValue->listItems[$indexListItem]);
                    continue;
                }
                $listItem->list_id = $snippetVarValue->id;

                $listItem->validateAndSave();

                $this->saveSnippetVarValues($listItem, 'list');
            }
        }
    }

    protected function redirectAfterSave($model, $editOptions = array(), $editView = 'edit')
    {
        Alert::success('Položka bola úspešne uložená.');
        $continue = Yii::$app->request->post('continue');

        if (isset($continue)) {
            return $this->redirect([$editView, 'id' => $model->id]);
        } else {
            return $this->redirect(['index']);
        }
    }

    protected function redirectAfterFail($model, $editOptions = array(), $editView = 'edit')
    {
        Alert::danger('Vyskytla sa chyba pri ukladaní položky.');

        return $this->render($editView, array_merge([
            'model' => $model
        ], $editOptions));
    }

    protected function ajaxValidation($model)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }

    /**
     * Basic delete method
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {
            Alert::success('Položka bola úspešne vymazaná.');
        } else {
            Alert::danger('Položku sa nepodarilo vymazať.');
        }

        return $this->redirect(['index']);
    }
}
