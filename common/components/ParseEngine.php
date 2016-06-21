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
use backend\models\Portal;
use backend\models\Product;
use backend\models\Row;
use backend\models\Section;
use backend\models\SnippetCode;
use backend\models\SnippetVar;
use backend\models\SnippetVarDefaultValue;
use backend\models\SnippetVarDropdown;
use backend\models\SnippetVarValue;
use backend\models\Tag;
use Exception;
use Yii;
use yii\db\mysql\QueryBuilder;
use yii\db\Query;
use yii\helpers\BaseVarDumper;
use yii\helpers\VarDumper;

class ParseEngine
{
    /** Metoda na presun dat z tabuliek product_snippet a portal_snippet do tabulky block
     * @param $portal
     */
    public function parsePortalSnippet(Portal $portal)
    {
        $transaction = Yii::$app->db->beginTransaction();

        $query = 'DELETE FROM portal_var_value WHERE value_block_id IS NOT NULL AND portal_id = :portal_id;';

        Yii::$app->db->createCommand($query, [
            'portal_id' => $portal->id
        ])
            ->execute();

        $query = 'INSERT INTO block (type, snippet_code_id, data, old_id)
              SELECT \'portal_snippet\', snippet_code_id, json, id FROM portal_snippet WHERE portal_id = :portal_id;';

        Yii::$app->db->createCommand($query, [
            'portal_id' => $portal->id
        ])
            ->execute();

        $query = 'INSERT INTO portal_var_value (portal_id, var_id, value_block_id)
            SELECT portal_snippet.portal_id, portal_snippet.portal_var_id, block.id FROM block JOIN portal_snippet ON (block.old_id = portal_snippet.id)
            WHERE type = \'portal_snippet\' AND portal_snippet.portal_id = :portal_id;';

        Yii::$app->db->createCommand($query, [
            'portal_id' => $portal->id
        ])
            ->execute();

        $parseEngine = new ParseEngine();

        foreach($portal->portalSnippets as $portalSnippet)
        {
            $portalSnippet->valueBlock->data = $parseEngine->convertMacrosToLatteStyle($portalSnippet->valueBlock->data);

            $portalSnippet->valueBlock->save();

            $parseEngine->parseSnippetVarValues($portalSnippet->valueBlock);
        }

        $transaction->commit();
    }

    public function parseProductSnippet(Product $product)
    {
        $transaction = Yii::$app->db->beginTransaction();

        $query = 'DELETE FROM product_var_value WHERE value_block_id IS NOT NULL AND product_id = :product_id;';

        Yii::$app->db->createCommand($query, [
            'product_id' => $product->id
        ])
            ->execute();

        $query = 'INSERT INTO block (type, snippet_code_id, data, old_id)
            SELECT \'product_snippet\', snippet_code_id, json, id FROM product_snippet WHERE product_id = :product_id;';

        Yii::$app->db->createCommand($query, [
            'product_id' => $product->id
        ])
            ->execute();

        $query = 'INSERT INTO product_var_value (product_id, var_id, value_block_id)
            SELECT product_snippet.product_id, product_snippet.product_var_id, block.id FROM block JOIN product_snippet ON (block.old_id = product_snippet.id)
            WHERE type = \'product_snippet\' AND product_snippet.product_id = :product_id;';

        Yii::$app->db->createCommand($query, [
            'product_id' => $product->id
        ])
            ->execute();

        $parseEngine = new ParseEngine();

        foreach($product->productSnippets as $productSnippet)
        {
            $productSnippet->valueBlock->data = $parseEngine->convertMacrosToLatteStyle($productSnippet->valueBlock->data);

            $productSnippet->valueBlock->save();

            $parseEngine->parseSnippetVarValues($productSnippet->valueBlock);
        }

        $transaction->commit();
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

                            $pageBlock->data = json_decode($result['json'], true)['content']['master'][$columnIndex . $rowIds[$i]][$tempId];

                            if (isset(json_decode($pageBlock->data)->code_select))
                                $pageBlock->snippet_code_id = json_decode($pageBlock->data)->code_select;
                            else
                                $pageBlock->snippet_code_id = json_decode(json_decode($pageBlock->data)->result)->code_select;

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
                    }
                }

            }
        }
    }

    public function parseSidebar($pageDbRow)
    {
        $rowIds = explode(',', $pageDbRow['block_poradie']);

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

            $columnsCount = 1;

            for ($columnIndex = 1; $columnIndex <= $columnsCount; $columnIndex++)
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
                    }
                }

            }
        }
    }

    /** Parsovanie dat z glob. hlavicky a paticky portalu ale aj podstranky
     * @param $dataType string typ - page, portal,
     * @param $dbRow - riadok tabulky, ktory parsujeme
     */
    public function parsePageGlobalSection($dataType, $tableRow)
    {
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
        $sectionsJsonSmartsnippet = json_decode($tableRow['json_smart_snippet'], true)[$type];
        $sectionsBlockSettings = json_decode($tableRow['block_settings'], true)[$type];

        foreach ($sectionsBlockPoradie as $sectionId => $sectionData)
        {
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
                                    {
                                        if (!isset($json['result']))
                                            continue;
                                        $json = $json['result'];
                                    }

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

        if (isset($pageBlock->snippetCode))
            $snippetId =  $pageBlock->snippetCode->snippet_id;
        else if (isset($pageBlock->parent))
            $snippetId = $pageBlock->parent->snippetCode->snippet_id;
        else
            return;

        foreach($json as $key => $value)
        {
            $key2 = str_replace('-', '_', $key);

            /* @var $snippetVar SnippetVar */
            $snippetVar = SnippetVar::find()
                ->andWhere(['snippet_id' => $snippetId])
                ->andFilterWhere([
                    'or',
                    ['identifier' => $key],
                    ['identifier' => $key2]
                ])
                ->one();

            $snippetVarValue = new SnippetVarValue();

            if ($snippetVar == null )
            {
                if ($key != 'button_text' && $key != 'button_url' && $key != 'init' && $key != 'active') //z tabulky splatok vyhodeny button
                {
                    VarDumper::dump('ERROR');
                }
                continue;
            }

            $snippetVarValue->block_id = $pageBlock->id;
            $snippetVarValue->var_id = $snippetVar->id;

            switch($snippetVar->type->identifier)
            {
                case 'list' :

                    $snippetVarValue->save(); //Needed to save to get ID
                    $this->parseSnippetList($value, $pageBlock, $snippetVar->id, $snippetVarValue);

                    break;
                case 'page' :

                    $page = Page::findOne(['id' => substr($value, 8)]);

                    if (isset($page))
                        $snippetVarValue->value_page_id = $page->id;

                    break;

                case 'product' :

                    $product = Product::findOne(['identifier' => $value]);

                    if (isset($product))
                        $snippetVarValue->value_product_id = $product->id;

                    break;
                case 'product_tag' :

                    $tag = Tag::findOne(['identifier' => $value]);

                    if (isset($tag))
                        $snippetVarValue->value_tag_id = $tag->id;

                    break;
                case 'dropdown' :

                    $dropdowns = SnippetVarDropdown::find()
                        ->where([
                            'var_id' => $snippetVarValue->var_id,
                        ])
                        ->orderBy('id')
                        ->all();

                    if (!isset($value) || ($value == '') || $value +1 > sizeof($dropdowns))
                        $snippetVarValue->value_dropdown_id = $snippetVar->defaultValue;
                    else
                        $snippetVarValue->value_dropdown_id = $dropdowns[$value]->id;

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
    private function parseSnippetList($value, Block $pageBlock, $listVarId, $snippetVarValue)
    {
        $list = new ListVar();
        $list->snippet_var_value_id = $snippetVarValue->id;
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
                    ->andWhere(['parent_id' => $listVarId])
                    ->one();

                if ($snippetListVar == null)
                {
                    if ($itemVarIdentifier != 'init' && $itemVarIdentifier != 'active')
                    {
                        VarDumper::dump('ERROR') . PHP_EOL;
                    }
                    continue;
                }

                /* @var $snippetListVarValue SnippetVarValue */
                $snippetListVarValue = new SnippetVarValue();

                $snippetListVarValue->var_id = $snippetListVar->id;
                $snippetListVarValue->list_item_id = $listItem->id;

                switch($snippetListVar->type->identifier)
                {
                    case 'list' :

                        $snippetListVarValue->save();
                        $this->parseSnippetList($itemVarValue, $pageBlock, $snippetListVar->id, $snippetListVarValue);

                        break;
                    case 'page' :

                        $page = Page::findOne(['id' => substr($itemVarValue, 8)]);

                        if (isset($page))
                            $snippetListVarValue->value_page_id = $page->id;

                        break;

                    case 'product' :

                        $product = Product::findOne(['identifier' => $itemVarValue]);

                        if (isset($product))
                            $snippetListVarValue->value_product_id = $product->id;

                        break;
                    case 'product_tag' :

                        $tag = Tag::findOne(['identifier' => $itemVarValue]);

                        if (isset($tag))
                            $snippetListVarValue->value_tag_id = $tag->id;

                        break;
                    case 'dropdown' :

                        $dropdowns = SnippetVarDropdown::find()
                            ->where([
                                'var_id' => $snippetListVarValue->var_id,
                            ])
                            ->orderBy('id')
                            ->all();

                        if (!isset($itemVarValue) || ($itemVarValue == '') || $itemVarValue +1 > sizeof($dropdowns))
                        {
                            $productTypeDefaultValue = SnippetVarDefaultValue::find()
                                ->andWhere([
                                    'snippet_var_id' => $snippetListVar->id,
                                    'product_type_id' => NULL
                                ])
                                ->one();

                            $snippetListVarValue->value_dropdown_id = $productTypeDefaultValue->value_dropdown_id;
                        }
                        else
                        {
                            $dropdowns = SnippetVarDropdown::find()
                                ->where([
                                    'var_id' => $snippetListVarValue->var_id,
                                    //'value' => $itemVarValue
                                ])
                                ->orderBy('id')
                                ->all();

                            if (array_key_exists($itemVarValue, $dropdowns))
                                $snippetListVarValue->value_dropdown_id = $dropdowns[$itemVarValue]->id;
                            else
                            {
                                $dropdown = SnippetVarDropdown::find()
                                    ->where([
                                        'var_id' => $snippetListVarValue->var_id,
                                        'value' => $itemVarValue
                                    ])
                                    ->orderBy('id')
                                    ->one();

                                $snippetListVarValue->value_dropdown_id = $dropdown->id;
                            }
                        }

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
     * @param string $string
     * @return mixed|string
     */
    public function convertMacrosToLatteStyle($string)
    {
        $string = str_replace('{dolna_hranica_pozicky}', '{$product->dolna_hranica_pozicky}', $string);
        $string = str_replace('{horna_hranica_pozicky}', '{$product->horna_hranica_pozicky}', $string);
        $string = str_replace('{dolna_hranica_splatnosti}', '{$product->dolna_hranica_splatnosti}', $string);
        $string = str_replace('{horna_hranica_splatnosti}', '{$product->horna_hranica_splatnosti}', $string);
        $string = str_replace('{horna_hranica_pozicky_novy}', '{$product->horna_hranica_pozicky_novy}', $string);
        $string = str_replace('{horna_hranica_splatnosti_novy}', '{$product->horna_hranica_splatnosti_novy}', $string);
        $string = str_replace('{nazov_produktu}', '{$product->nazov_produktu}', $string);
        $string = str_replace('{urok_porovnavac}', '{$product->urok_porovnavac}', $string);

        $string = str_replace('{slovnik.', '{$slovnik->', $string);

        $string = str_replace('{$dolna_hranica_pozicky}', '{$product->dolna_hranica_pozicky}', $string);
        $string = str_replace('{$horna_hranica_pozicky}', '{$product->horna_hranica_pozicky}', $string);
        $string = str_replace('{$dolna_hranica_splatnosti}', '{$product->dolna_hranica_splatnosti}', $string);
        $string = str_replace('{$horna_hranica_splatnosti}', '{$product->horna_hranica_splatnosti}', $string);
        $string = str_replace('{$horna_hranica_pozicky_novy}', '{$product->horna_hranica_pozicky_novy}', $string);
        $string = str_replace('{$horna_hranica_splatnosti_novy}', '{$product->horna_hranica_splatnosti_novy}', $string);
        $string = str_replace('{$nazov_produktu}', '{$product->nazov_produktu}', $string);
        $string = str_replace('{$urok_porovnavac}', '{$product->urok_porovnavac}', $string);

        return $string;
    }

}