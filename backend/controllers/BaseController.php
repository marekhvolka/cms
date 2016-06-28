<?php

namespace backend\controllers;

use backend\components\BlockModal\BlockModalWidget;
use backend\components\LayoutWidget\LayoutWidget;
use backend\models\Block;
use backend\models\Column;
use backend\models\CustomModel;
use backend\models\ListItem;
use backend\models\ListVar;
use backend\models\Page;
use backend\models\Portal;
use backend\models\Row;
use backend\models\search\GlobalSearch;
use backend\models\Section;
use backend\models\SnippetVar;
use backend\models\SnippetVarValue;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

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

        $change_portal = Yii::$app->request->get('change-portal');

        if (!empty($change_portal) && Portal::find()->where(['id' => $change_portal])->count() == 1) {
            Yii::$app->session->set('portal_id', $change_portal);
        }
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

    /**
     * Action necessary for LayoutWidget - appending one section at the end of the list.
     * @return string - call of LayoutWidget method for rendering view.
     * @internal param string $type
     */
    public function actionAppendSection()
    {
        $type = Yii::$app->request->post('type');
        $portalId = Yii::$app->request->post('portalId');
        $pageId = Yii::$app->request->post('pageId');

        $prefix = Yii::$app->request->post('prefix');

        $section = new Section();
        $section->type = $type;
        $section->portal_id = $portalId;
        $section->page_id = $pageId;

        $indexSection = rand(1000, 10000000);

        return (new LayoutWidget())->appendSection($section, $prefix, $indexSection);
    }

    /**
     * Action necessary for LayoutWidget - appending one row at the end of the list.
     * @return string - call of LayoutWidget method for rendering view.
     */
    public function actionAppendRow()
    {
        $prefix = Yii::$app->request->post('prefix');

        $row = new Row();

        $indexRow = rand(1000, 10000000);

        return (new LayoutWidget())->appendRow($row, $prefix, $indexRow);
    }

    public function actionAppendColumns()
    {
        $width = Yii::$app->request->post('width');

        $prefix = Yii::$app->request->post('prefix');

        $columnsData = array();

        for ($i = 0; $i < sizeof($width); $i++) {
            $column = new Column();
            $column->order = $i + 1;
            $column->width = $width[$i];

            $indexColumn = rand(1000, 10000000);

            $columnsData[] = (new LayoutWidget())->appendColumn($column, $prefix, $indexColumn);
        }
        return json_encode($columnsData);
    }

    /**
     * Action necessary for LayoutWidget - appending one block at the end of the list.
     * @return string - call of LayoutWidget method for rendering view.
     */
    public function actionAppendBlock()
    {
        $columnId = Yii::$app->request->post('columnId');

        $prefix = Yii::$app->request->post('prefix');

        $indexBlock = rand(1000, 1000000);

        $block = new Block();
        $block->column_id = $columnId;
        $block->type = 'text'; // TODO test data.

        return (new LayoutWidget())->appendBlock($block, $prefix, $indexBlock);
    }

    public function actionAppendBlockModal($id, $prefix)
    {
        //$blockId = Yii::$app->request->post('id');
        //$prefix = Yii::$app->request->post('prefix');

        $block = Block::findOne(['id' => $id]);

        return (new BlockModalWidget())->appendModal($block, $prefix);
    }

    public function actionAppendListItem($parentVarId, $prefix)
    {
        //$listId = Yii::$app->request->post('listId');
        //$prefix = Yii::$app->request->post('prefix');

        $parentVar = SnippetVar::find()->where(['id' => $parentVarId])->one();

        $listItem = $parentVar->createNewListItem();

        $indexItem = rand(1000, 10000);

        return (new BlockModalWidget())->appendListItem($listItem, $prefix, $indexItem);
    }

    public function actionCacheFromBuffer($limit = 20)
    {
        $query = 'SELECT * FROM cache_page ORDER BY priority DESC, added_at ASC LIMIT :limit';

        $command = Yii::$app->db->createCommand($query);
        $command->bindValue(':limit', $limit);

        $results = $command->queryAll();

        foreach ($results as $row) {
            $page = Page::find()->where(['id' => $row['page_id']])->one();

            $page->getMainCacheFile(true);

            $removeQuery = 'DELETE FROM cache_page WHERE id = :id';

            $removeCommand = Yii::$app->db->createCommand($removeQuery);
            $removeCommand->bindValue(':id', $row['id']);

            $removeCommand->execute();
        }
    }

    /** Metoda na nacitanie a ulozenie dat pre layout
     * @param CustomModel $model
     * @param $sectionsData
     * @param $propertyIdentifier
     * @throws \yii\base\Exception
     */
    public function loadLayout(CustomModel $model, $sectionsData, $propertyIdentifier)
    {
        $sectionOrderIndex = 1;
        foreach ($sectionsData as $indexSection => $itemSection) {
            $itemSection['order'] = $sectionOrderIndex++;
            $model->loadFromData($propertyIdentifier, $itemSection, $indexSection, Section::className());

            if (!key_exists('Row', $itemSection)) {
                continue;
            }

            $section = $model->{$propertyIdentifier}[$indexSection];

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
                        $block->changed = true;

                        $this->loadSnippetVarValues($itemBlock, $block);
                    }
                }
            }
        }
    }

    public function saveLayout($model, $propertyIdentifier, $type)
    {
        foreach ($model->{$propertyIdentifier} as $section) {
            if ($type == 'page') {
                $section->page_id = $model->id;
            } else if ($type == 'portal') {
                $section->portal_id = $model->id;
            }

            if ($section->removed) {
                $section->delete();
                continue;
            } else if (!($section->validate() && $section->save())) {
                throw new Exception;
            }

            foreach ($section->rows as $row) {
                $row->section_id = $section->id;

                if ($row->removed) {
                    $row->delete();
                    continue;
                }
                if (!($row->validate() && $row->save())) {
                    throw new Exception;
                }

                foreach ($row->columns as $column) {
                    $column->row_id = $row->id;

                    if ($column->removed) {
                        $column->delete();
                        continue;
                    }
                    if (!($column->validate() && $column->save())) {
                        throw new Exception;
                    }

                    foreach ($column->blocks as $block) {
                        $block->column_id = $column->id;

                        if ($block->removed) {
                            $block->delete();
                            continue;
                        }
                        if (!($block->validate() && $block->save())) {
                            throw new Exception;
                        }

                        if ($block->changed) {
                            $this->saveSnippetVarValues($block);
                        }
                    }
                }
            }
        }
    }

    private function loadSnippetVarValues($data, $model)
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

    private function saveSnippetVarValues($model, $type = 'block')
    {
        foreach ($model->snippetVarValues as $snippetVarValue) {

            if ($type == 'block') {
                $snippetVarValue->block_id = $model->id;
            } else if ($type == 'list') {
                $snippetVarValue->list_item_id = $model->id;
            }

            if (!($snippetVarValue->validate() && $snippetVarValue->save())) {
                throw new Exception;
            }

            $listItemOrder = 1;
            foreach ($snippetVarValue->listItems as $listItem) {
                if ($listItem->removed) {
                    $listItem->delete();
                    continue;
                }
                $listItem->list_id = $snippetVarValue->id;
                $listItem->order = $listItemOrder++;

                if (!($listItem->validate() && $listItem->save())) {
                    throw new Exception;
                }

                $this->saveSnippetVarValues($listItem, 'list');
            }
        }
    }
}
