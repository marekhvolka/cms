<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 10.05.16
 * Time: 21:52
 */

namespace common\components;


use backend\models\Column;
use backend\models\ListItem;
use backend\models\ListVar;
use backend\models\Page;
use backend\models\Block;
use backend\models\Product;
use backend\models\Row;
use backend\models\Section;
use backend\models\SnippetCode;
use backend\models\SnippetVar;
use backend\models\SnippetVarValue;
use backend\models\Tag;
use Yii;
use yii\db\mysql\QueryBuilder;
use yii\db\Query;
use yii\helpers\BaseVarDumper;
use yii\helpers\VarDumper;

class ParseEngine
{
    /** Metoda na presun dat z tabuliek product_snippet a portal_snippet do tabuliek page_block
     * @param $type string
     */
    public function parsePortalProductSnippet($type)
    {
        if ($type == 'product')
        {
            $tableName = 'product_snippet';
        }
        else if ($type == 'portal')
            $tableName = 'portal_snippet';

        $result = $command = (new Query())
            ->select('*')
            ->from($tableName)
            ->createCommand()
            ->queryAll();

        //TODO: dokoncit
    }

    /**
     *  Metoda na parsovanie hlavneho obsahu stranky - data su ulozene v tabulke page a presunu sa do tabuliek
     * section, row, column, pageblock
     * @param $pageDbRow - riadok tabulky
     */
    public function parseMasterContent($pageDbRow)
    {
        $rowIds = explode(',', $pageDbRow['layout_poradie_id']);

        $rowWidth = explode(',', $pageDbRow['layout_poradie']);

        $section = Section::findOne(
            [
                'page_id' => $pageDbRow['id'],
                'type' => 'content'
            ]
        );

        if ($section == NULL)
        {
            $section = new Section();
            $section->page_id = $pageDbRow['id'];
            $section->type = 'content';

            $section->save();
        }

        for ($i = 0; $i < sizeof($rowIds); $i++) //loop through rows
        {
            //VarDumper::dump('Row ' . $rowIds[$i] . PHP_EOL);

            $row = new Row();

            $row->section_id = $section->id;
            $row->order = $i + 1;

            if ($row->validate())
            {
                $row->save();
            }
            else
            {
                BaseVarDumper::dump($row->errors);
            }

            $layoutData = json_decode($pageDbRow['layout_element'], true);

            if (!isset($layoutData['content']))
                continue;

            $columns = $layoutData['content']['master'];

            $columnsCount = strlen($rowWidth[$i]) > 1 ? 2 : intval($rowWidth[$i]);


            for($columnIndex = 1; $columnIndex <= $columnsCount; $columnIndex++)
            {
                //VarDumper::dump('Column ' . $columnIndex . $rowIds[$i] . PHP_EOL);

                $column = new Column();
                $column->row_id = $row->id;
                $column->order = $columnIndex;

                if ($rowWidth[$i] === '2_1')
                {
                    $column->width = 12 - $columnIndex * 4;
                }
                else if ($rowWidth[$i] === '1_2')
                {
                    $column->width = $columnIndex * 4;
                }
                else
                {
                    $column->width = 12/$columnsCount;
                }

                if ($column->validate())
                {
                    $column->save();
                }
                else
                {
                    BaseVarDumper::dump($column->errors);
                }

                $pageBlockOrder = 1;

                $data = json_decode($pageDbRow['layout_element'], true)['content']['master'];

                if (!isset($data[$columnIndex . $rowIds[$i]]))
                    continue;

                foreach ($data[$columnIndex . $rowIds[$i]] as $tempId => $snippetCodeId)
                {
                    $pageBlockType = json_decode($pageDbRow['layout_element_type'], true)['content']['master'][$columnIndex . $rowIds[$i]][$tempId];

                    //VarDumper::dump('Page Block ' . $pageBlockType . PHP_EOL);

                    $pageBlock = new Block();

                    $pageBlock->order = $pageBlockOrder++;

                    $pageBlock->column_id = $column->id;
                    $pageBlock->active = json_decode($pageDbRow['layout_element_active'], true)['content']['master'][$columnIndex . $rowIds[$i]][$tempId];

                    switch($pageBlockType)
                    {
                        case 'smart_snippet' :

                            $pageBlock->type = 'snippet';

                            $result = $command = (new Query())
                                ->select('*')
                                ->from('page_snippet')
                                ->where(['page_id' => $pageDbRow['id']])
                                ->createCommand()
                                ->queryOne();

                            $pageBlock->snippet_code_id = $snippetCodeId = $pageBlock->data = json_decode(json_decode($result['json'], true)['content']['master'][$columnIndex . $rowIds[$i]][$tempId])->code_select;

                            $pageBlock->data = json_decode($result['json'], true)['content']['master'][$columnIndex . $rowIds[$i]][$tempId];

                            break;

                        case 'html' :

                            $pageBlock->type = 'html';
                            $pageBlock->data = json_decode($pageDbRow['layout_element'], true)['content']['master'][$columnIndex . $rowIds[$i]][$tempId];

                            break;

                        case 'portal_snippet' :
                            $pageBlock->type = 'portal_snippet';

                            $old_portal_snippet_id = json_decode($pageDbRow['layout_element'], true)['content']['master'][$columnIndex . $rowIds[$i]][$tempId];

                            $parentBlock = Block::find()
                                ->andWhere([
                                    'type' => 'portal_snippet',
                                    'old_id' => $old_portal_snippet_id
                                ])
                                ->one();

                            $pageBlock->parent_id = $parentBlock->id;

                            $result = $command = (new Query())
                                ->select('*')
                                ->from('page_snippet')
                                ->where(['page_id' => $pageDbRow['id']])
                                ->createCommand()
                                ->queryOne();

                            $pageBlock->data = json_decode($result['json'], true)['content']['master'][$columnIndex . $rowIds[$i]][$tempId];

                            break;
                        case 'product_snippet':
                            $pageBlock->type = 'product_snippet';

                            $old_product_snippet_id = json_decode($pageDbRow['layout_element'], true)['content']['master'][$columnIndex . $rowIds[$i]][$tempId];

                            $parentBlock = Block::find()
                                ->andWhere([
                                    'type' => 'product_snippet',
                                    'old_id' => $old_product_snippet_id
                                ])
                                ->one();

                            $pageBlock->parent_id = $parentBlock->id;

                            $result = $command = (new Query())
                                ->select('*')
                                ->from('page_snippet')
                                ->where(['page_id' => $pageDbRow['id']])
                                ->createCommand()
                                ->queryOne();

                            $pageBlock->data = json_decode($result['json'], true)['content']['master'][$columnIndex . $rowIds[$i]][$tempId];

                            break;

                        case 'text' :

                            $pageBlock->type = 'text';
                            $pageBlock->data = json_decode($pageDbRow['layout_element'], true)['content']['master'][$columnIndex . $rowIds[$i]][$tempId];
                            break;
                    }

                    if ($pageBlock->validate())
                    {
                        $pageBlock->save();
                    }
                    else
                    {
                        BaseVarDumper::dump($pageBlock->errors);

                        BaseVarDumper::dump($pageBlock->snippet_code_id);
                        BaseVarDumper::dump($section->page_id);
                    }
                }

            }
        }


        /*
        $pagesBlockSett = $command = (new Query())
            ->select('*')
            ->from('page_block_sett')
            ->createCommand()
            ->queryAll();

        foreach ($pagesBlockSett as $page)
        {
            $rows = json_decode($page['settings']['content']);

            foreach ($rows as $rowId => $row) //loop through rows
            {
                $json = json_decode($row);

                $command = Yii::$app->db->createCommand('UPDATE row
                        SET
                        VALUES(:section_id, :id)');

                $command->bindValue(':section_id', $section['id']);
                $command->bindValue(':id', $rowIds[$i]);

                $command->execute();
            }
        }*/
    }

    public function parseSidebar($pageDbRow)
    {
        $rowIds = explode(',', $pageDbRow['block_poradie']);

        //$rowWidth = explode(',', $pageDbRow['layout_poradie']);

        $section = Section::findOne(
            [
                'page_id' => $pageDbRow['page_id'],
                'type' => 'sidebar'
            ]
        );

        if ($section == NULL)
        {
            $section = new Section();
            $section->page_id = $pageDbRow['page_id'];
            $section->type = 'sidebar';

            $section->save();
        }

        for ($i = 0; $i < sizeof($rowIds); $i++) //loop through rows
        {
            //VarDumper::dump('Row ' . $rowIds[$i] . PHP_EOL);

            $row = new Row();

            $row->section_id = $section->id;
            $row->order = $i + 1;

            if ($row->validate())
            {
                $row->save();
            }
            else
            {
                BaseVarDumper::dump($row->errors);
            }

            $layoutData = json_decode($pageDbRow['layout_element'], true);

            if (!isset($layoutData['sidebar']))
                continue;

            $columns = $layoutData['sidebar']['master'];

            $columnsCount = 1;

            for($columnIndex = 1; $columnIndex <= $columnsCount; $columnIndex++)
            {
                $column = new Column();
                $column->row_id = $row->id;
                $column->order = $columnIndex;

                $column->width = 12;

                if ($column->validate())
                {
                    $column->save();
                }
                else
                {
                    BaseVarDumper::dump($column->errors);
                }

                $pageBlockOrder = 1;

                $data = json_decode($pageDbRow['layout_element'], true)['sidebar']['master'];

                if (!isset($data[$columnIndex . $rowIds[$i]]))
                    continue;

                foreach ($data[$columnIndex . $rowIds[$i]] as $tempId => $snippetCodeId)
                {
                    $pageBlockType = json_decode($pageDbRow['layout_element_type'], true)['sidebar']['master'][$columnIndex . $rowIds[$i]][$tempId];

                    //VarDumper::dump('Page Block ' . $pageBlockType . PHP_EOL);

                    $pageBlock = new Block();

                    $pageBlock->order = $pageBlockOrder++;

                    $pageBlock->column_id = $column->id;
                    $pageBlock->active = json_decode($pageDbRow['layout_element_active'], true)['sidebar']['master'][$columnIndex . $rowIds[$i]][$tempId];

                    switch($pageBlockType)
                    {
                        case 'smart_snippet' :

                            $json = json_decode($pageDbRow['json_smart_snippet'], true)['sidebar']['master'][$columnIndex . $rowIds[$i]][$tempId];

                            $pageBlock->type = 'snippet';

                            $pageBlock->snippet_code_id = json_decode($json)->code_select;

                            $pageBlock->data = $json;

                            break;

                        case 'html' :

                            $pageBlock->type = 'html';
                            $pageBlock->data = json_decode($pageDbRow['layout_element'], true)['sidebar']['master'][$columnIndex . $rowIds[$i]][$tempId];

                            break;

                        case 'text' :
                            $pageBlock->type = 'text';
                            $pageBlock->data = json_decode($pageDbRow['layout_element'], true)['sidebar']['master'][$columnIndex . $rowIds[$i]][$tempId];

                            break;
                        case 'portal_snippet' :
                            $pageBlock->type = 'portal_snippet';

                            $old_portal_snippet_id = json_decode($pageDbRow['layout_element'], true)['sidebar']['master'][$columnIndex . $rowIds[$i]][$tempId];

                            $parentBlock = Block::find()
                                ->andWhere([
                                    'type' => 'portal_snippet',
                                    'old_id' => $old_portal_snippet_id
                                ])
                                ->one();

                            $pageBlock->parent_id = $parentBlock->id;

                            $pageBlock->data = json_decode($pageDbRow['json_smart_snippet'], true)['sidebar']['master'][$columnIndex . $rowIds[$i]][$tempId];

                            break;
                        case 'product_snippet':
                            $pageBlock->type = 'product_snippet';

                            $old_product_snippet_id = json_decode($pageDbRow['layout_element'], true)['sidebar']['master'][$columnIndex . $rowIds[$i]][$tempId];

                            $parentBlock = Block::find()
                                ->andWhere([
                                    'type' => 'product_snippet',
                                    'old_id' => $old_product_snippet_id
                                ])
                                ->one();

                            $pageBlock->parent_id = $parentBlock->id;

                            $pageBlock->data = json_decode($pageDbRow['json_smart_snippet'], true)['sidebar']['master'][$columnIndex . $rowIds[$i]][$tempId];

                            break;
                    }

                    if ($pageBlock->validate())
                    {
                        $pageBlock->save();
                    }
                    else
                    {
                        BaseVarDumper::dump($pageBlock->errors);

                        BaseVarDumper::dump($pageBlock->snippet_code_id);
                        BaseVarDumper::dump($section->page_id);
                    }
                }

            }
        }


        /*
        $pagesBlockSett = $command = (new Query())
            ->select('*')
            ->from('page_block_sett')
            ->createCommand()
            ->queryAll();

        foreach ($pagesBlockSett as $page)
        {
            $rows = json_decode($page['settings']['content']);

            foreach ($rows as $rowId => $row) //loop through rows
            {
                $json = json_decode($row);

                $command = Yii::$app->db->createCommand('UPDATE row
                        SET
                        VALUES(:section_id, :id)');

                $command->bindValue(':section_id', $section['id']);
                $command->bindValue(':id', $rowIds[$i]);

                $command->execute();
            }
        }*/
    }

    /** Parsovanie dat z glob. hlavicky a paticky portalu ale aj podstranky
     * @param $dataType string typ - page, portal,
     * @param $dbRow - riadok tabulky, ktory parsujeme
     */
    public function parsePageGlobalSection($dataType, $tableRow)
    {
        //VarDumper::dump($tableRow['id']);

        if ($tableRow['sekcia_settings'] == '' || $tableRow['layout_element'] == '')
            return;

        if (isset(json_decode($tableRow['layout_element'], true)['header']))
        {
            $type = 'header';
        }
        else if (isset(json_decode($tableRow['layout_element'], true)['footer']))
        {
            $type = 'footer';
        }

        $sectionsLayoutElement = json_decode($tableRow['layout_element'], true)[$type];
        $sectionsCssSettings = json_decode($tableRow['sekcia_settings'], true)[$type];
        $sectionsBlockPoradie = json_decode($tableRow['block_poradie'], true)[$type];
        $sectionsLayoutElementType = json_decode($tableRow['layout_element_type'], true)[$type];
        $sectionsLayoutElementActive = json_decode($tableRow['layout_element_active'], true)[$type];
        $sectionsLayoutElementTimeFrom = json_decode($tableRow['layout_element_time_from'], true)[$type];
        $sectionsLayoutElementTimeTo = json_decode($tableRow['layout_element_time_to'], true)[$type];
        $sectionsJsonSmartsnippet = json_decode($tableRow['json_smart_snippet'], true)[$type];
        $sectionsBlockSettings = json_decode($tableRow['block_settings'], true)[$type];

        //BaseVarDumper::dump('Riadok ' . $tableRow['id']);

        foreach ($sectionsBlockPoradie as $sectionId => $sectionData)
        {
            //BaseVarDumper::dump('Sekcia  ' . $sectionId . PHP_EOL);

            try
            {
                $section = new Section();

                if ($dataType == 'page')
                {
                    $section->page_id = $tableRow['page_id'];
                    $section->portal_id = NULL;
                }
                else if ($dataType == 'portal')
                {
                    $section->portal_id = $tableRow['portal_id'];
                    $section->page_id = NULL;
                }

                $section->type = $type;
                $section->css_style = json_decode($sectionsCssSettings[$sectionId], true)['style_sett'];
                $section->css_class = json_decode($sectionsCssSettings[$sectionId], true)['class_sett'];
                $section->css_id = json_decode($sectionsCssSettings[$sectionId], true)['id_sett'];

                if ($section->validate())
                {
                    $section->save();
                }
                else
                {
                    BaseVarDumper::dump($section->errors);
                }

                if (!array_key_exists(0, json_decode($sectionsBlockPoradie[$sectionId], true))
                    || !isset(json_decode($sectionsBlockPoradie[$sectionId], true)[0]))
                    continue;

                if (!array_key_exists(0, json_decode($sectionsBlockPoradie[$sectionId], true)[0]))
                    continue;

                $rowType = json_decode($sectionsBlockPoradie[$sectionId], true)[0][0]['name'];

                $sectionData = json_decode($sectionData, true);

                if (empty($sectionData))
                    continue;

                $rowOrder = 1;
                foreach ($sectionData[0] as $rowData)
                {
                    $columnsCount = strlen($rowData['name']) > 1 ? 2 : intval($rowData['name']);

                    $poradieID = str_replace('master_', '', $rowData["id"]);

                    $row = new Row();
                    $row->section_id = $section->id;
                    $row->order = $rowOrder++;

                    if ($row->validate())
                    {
                        $row->save();
                    }
                    else
                    {
                        BaseVarDumper::dump($row->errors);
                    }

                    //BaseVarDumper::dump($columnsCount . PHP_EOL);

                    for($index = 1; $index <= $columnsCount; $index++)
                    {
                        $column = new Column();

                        $column->row_id = $row->id;
                        $column->order = $index;

                        $settings = json_decode($sectionsBlockSettings[$index . $poradieID], true);

                        if (!empty($settings))
                            $column->css_style = $settings['style_sett'];
                            $column->css_class = $settings['class_sett'];
                            $column->css_id = $settings['id_sett'];

                        if ($rowType === '2_1')
                        {
                            $column->width = 12 - $index * 4;
                        }
                        else if ($rowType === '1_2')
                        {
                            $column->width = $index * 4;
                        }
                        else
                        {
                            $column->width = 12/$columnsCount;
                        }

                        //BaseVarDumper::dump('Sirka ' .$column->width . PHP_EOL);

                        if ($column->validate())
                        {
                            $column->save();
                        }
                        else
                        {
                            BaseVarDumper::dump($column->errors);
                        }

                        $pageBlockOrder = 1;
                        if (!isset($sectionsLayoutElement[$sectionId]))
                            continue;

                        if (!isset($sectionsLayoutElement[$sectionId][$index . $poradieID]))
                            continue;

                        foreach ($sectionsLayoutElement[$sectionId][$index . $poradieID] as $tempId => $snippetCodeId)
                        {
                            $pageBlockType = $sectionsLayoutElementType[$sectionId][$index . $poradieID][$tempId];

                            $pageBlock = new Block();

                            $pageBlock->order = $pageBlockOrder++;

                            $pageBlock->column_id = $column->id;
                            $pageBlock->active = $sectionsLayoutElementActive[$sectionId][$index . $poradieID][$tempId];

                            switch($pageBlockType)
                            {
                                case 'smart_snippet' :

                                    $json = json_decode($sectionsJsonSmartsnippet[$sectionId][$index . $poradieID][$tempId], true);

                                    if (!isset($json['code_select']))
                                        continue;

                                    $pageBlock->type = 'snippet';

                                    $snippetCode = SnippetCode::findOne(['id' => $json['code_select']]);

                                    if ($snippetCode == NULL)
                                        $pageBlock->snippet_code_id = NULL;
                                    else
                                        $pageBlock->snippet_code_id = $json['code_select'];

                                    $pageBlock->data = json_encode($json);

                                    break;

                                case 'portal_snippet' :
                                    $pageBlock->type = 'portal_snippet';

                                    $old_portal_snippet_id = json_decode($tableRow['layout_element'], true)[$type][$sectionId][$index . $poradieID][$tempId];

                                    $parentBlock = Block::find()
                                        ->andWhere([
                                            'type' => 'portal_snippet',
                                            'old_id' => $old_portal_snippet_id
                                        ])
                                        ->one();

                                    $pageBlock->parent_id = $parentBlock->id;

                                    $pageBlock->data = $sectionsJsonSmartsnippet[$sectionId][$index . $poradieID][$tempId];

                                    break;
                                case 'product_snippet':
                                    $pageBlock->type = 'product_snippet';

                                    $old_product_snippet_id = json_decode($tableRow['layout_element'], true)[$type][$sectionId][$index . $poradieID][$tempId];

                                    $parentBlock = Block::find()
                                        ->andWhere([
                                            'type' => 'product_snippet',
                                            'old_id' => $old_product_snippet_id
                                        ])
                                        ->one();

                                    $pageBlock->parent_id = $parentBlock->id;

                                    $pageBlock->data = $sectionsJsonSmartsnippet[$sectionId][$index . $poradieID][$tempId];
                                    break;

                                case 'html' :

                                    $pageBlock->type = 'html';
                                    $pageBlock->snippet_code_id = NULL;
                                    $pageBlock->data = $sectionsLayoutElement[$sectionId][$index . $poradieID][$tempId];

                                    break;

                                case 'text' :

                                    $pageBlock->type = 'text';
                                    $pageBlock->data = $sectionsLayoutElement[$sectionId][$index . $poradieID][$tempId];
                                    break;
                            }

                            if ($pageBlock->validate())
                            {
                                $pageBlock->save();
                            }
                            else
                            {
                                BaseVarDumper::dump($pageBlock->errors);

                                BaseVarDumper::dump($pageBlock->type);
                                BaseVarDumper::dump($section->page_id);
                            }
                        }
                    }
                }
            }
            catch (Exception $e)
            {
                VarDumper::dump($e);
            }
        }
        //die();

    }

    /** Parsovanie dat vyplneneho snippetu z JSONU do tabulky snippet_var_value
     * @param $pageBlock - blok, z ktorych budeme parsovat data
     */
    public function parseSnippetVarValues($pageBlock)
    {
        $data = json_decode($pageBlock->data);

        if ($data == '[]' || !is_object($data))
            return;

        if (!isset($data->snippet))
            return;
        $json = $data->snippet;

        foreach($json as $key => $value)
        {
            $key2 = str_replace('-', '_', $key);

            /* @var $snippetVar SnippetVar */
            $snippetVar = SnippetVar::find()
                ->andWhere(['snippet_id' => $pageBlock->snippetCode->snippet_id])
                ->andFilterWhere([
                    'or',
                    ['identifier' => $key],
                    ['identifier' => $key2]
                ])
                ->one();

            $snippetVarValue = new SnippetVarValue();

            if ($snippetVar == null )
            {
                if ($key != 'button_text' && $key != 'button_url') //z tabulky splatok vyhodeny button
                {
                    VarDumper::dump('ERROR');
                    VarDumper::dump($pageBlock);
                    VarDumper::dump($key);
                }
                continue;
            }

            $snippetVarValue->block_id = $pageBlock->id;
            $snippetVarValue->var_id = $snippetVar->id;

            switch($snippetVar->type->identifier)
            {
                case 'list':
                    $snippetVarValue->value_list_id = $this->parseSnippetList($value, $pageBlock);

                    break;
                case 'page':

                    $page = Page::findOne(['id' => substr($value, 8)]);

                    if (isset($page))
                        $snippetVarValue->value_page_id = $page->id;

                    break;

                case 'product':

                    $product = Product::findOne(['identifier' => $value]);

                    if (isset($product))
                        $snippetVarValue->value_product_id = $product->id;

                    break;
                case 'product_tag':

                    $tag = Tag::findOne(['identifier' => $value]);

                    if (isset($tag))
                        $snippetVarValue->value_tag_id = $tag->id;

                    break;
                default:
                    $snippetVarValue->value_text = $value;
            }

            if ($snippetVarValue->validate())
            {
                $snippetVarValue->save();
            }
            else
            {
                BaseVarDumper::dump($snippetVarValue->errors);
            }
        }

    }

    /** Pomocna metoda pre parsovanie zoznamov - rekurzivne sa vola pre zoznamy nizsich urovni
     * @param $value - cast jsonu, z ktorej sa parsuju data
     * @param $pageBlock Block - blok, ktoreho sa zoznamy tykaju
     * @return int
     */
    private function parseSnippetList($value, Block $pageBlock)
    {
        $list = new ListVar();
        $list->save();

        $order = 0;
        foreach($value as $item)
        {
            $listItem = new ListItem();
            $listItem->active = $item->active;
            $listItem->list_id = $list->id;
            $listItem->order = $order++;

            $listItem->save();

            foreach($item as $itemVarIdentifier => $itemVarValue)
            {
                $itemVarIdentifier2 = str_replace('-', '_', $itemVarIdentifier);

                /* @var $snippetListVar SnippetVar */
                $snippetListVar = SnippetVar::find()
                    ->andWhere(['snippet_id' => $pageBlock->snippetCode->snippet_id])
                    ->andFilterWhere([
                        'or',
                        ['identifier' => $itemVarIdentifier],
                        ['identifier' => $itemVarIdentifier2]
                    ])
                    ->one();

                if ($snippetListVar == null)
                {
                    if ($itemVarIdentifier != 'init' && $itemVarIdentifier != 'active')
                    {
                        VarDumper::dump('ERROR') . PHP_EOL;
                        VarDumper::dump($itemVarIdentifier);
                    }
                    continue;
                }

                /* @var $snippetListVarValue SnippetVarValue */
                $snippetListVarValue = new SnippetVarValue();

                $snippetListVarValue->var_id = $snippetListVar->id;
                $snippetListVarValue->list_item_id = $listItem->id;

                switch($snippetListVar->type->identifier)
                {
                    case 'list':
                        $snippetListVarValue->value_list_id = $this->parseSnippetList($itemVarValue, $pageBlock);

                        break;
                    case 'page':

                        $page = Page::findOne(['id' => substr($itemVarValue, 8)]);

                        if (isset($page))
                            $snippetListVarValue->value_page_id = $page->id;

                        break;

                    case 'product':

                        $product = Product::findOne(['identifier' => $itemVarValue]);

                        if (isset($product))
                            $snippetListVarValue->value_product_id = $product->id;

                        break;
                    case 'product_tag':

                        $tag = Tag::findOne(['identifier' => $itemVarValue]);

                        if (isset($tag))
                            $snippetListVarValue->value_tag_id = $tag->id;

                        break;
                    default:
                        $snippetListVarValue->value_text = $itemVarValue;
                }

                if ($snippetListVarValue->validate())
                {
                    $snippetListVarValue->save();
                }
                else
                {
                    BaseVarDumper::dump($snippetListVarValue->getErrors());
                }
            }
        }

        return $list->id;
    }

    /** Funkcia prekonvertuje zapisane premenne pre dany blok na Latte style
     * @param Block $block
     */
    public function convertMacrosToLatteStyle(Block $block)
    {
        $block->data = str_replace('{dolna_hranica_pozicky}', '{$product->dolna_hranica_pozicky}', $block->data);
        $block->data = str_replace('{horna_hranica_pozicky}', '{$product->horna_hranica_pozicky}', $block->data);
        $block->data = str_replace('{dolna_hranica_splatnosti}', '{$product->dolna_hranica_splatnosti}', $block->data);
        $block->data = str_replace('{horna_hranica_splatnosti}', '{$product->horna_hranica_splatnosti}', $block->data);
        $block->data = str_replace('{horna_hranica_pozicky_novy}', '{$product->horna_hranica_pozicky_novy}', $block->data);
        $block->data = str_replace('{horna_hranica_splatnosti_novy}', '{$product->horna_hranica_splatnosti_novy}', $block->data);
        $block->data = str_replace('{nazov_produktu}', '{$product->nazov_produktu}', $block->data);

        $block->data = str_replace('{slovnik.', '{$slovnik->', $block->data);

        $block->save();
    }

    /** Funkcia prekonvertuje zapisane premenne pre dany blok na Latte style
     * @param Block $block
     */
    public function convertMacrosToLatteStyle2(Block $block)
    {
        $block->data = str_replace('{$dolna_hranica_pozicky}', '{$product->dolna_hranica_pozicky}', $block->data);
        $block->data = str_replace('{$horna_hranica_pozicky}', '{$product->horna_hranica_pozicky}', $block->data);
        $block->data = str_replace('{$dolna_hranica_splatnosti}', '{$product->dolna_hranica_splatnosti}', $block->data);
        $block->data = str_replace('{$horna_hranica_splatnosti}', '{$product->horna_hranica_splatnosti}', $block->data);
        $block->data = str_replace('{$horna_hranica_pozicky_novy}', '{$product->horna_hranica_pozicky_novy}', $block->data);
        $block->data = str_replace('{$horna_hranica_splatnosti_novy}', '{$product->horna_hranica_splatnosti_novy}', $block->data);
        $block->data = str_replace('{$nazov_produktu}', '{$product->nazov_produktu}', $block->data);

        $block->save();
    }

}