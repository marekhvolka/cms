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
use backend\models\PageBlock;
use backend\models\Product;
use backend\models\Row;
use backend\models\Section;
use backend\models\SnippetCode;
use backend\models\SnippetVar;
use backend\models\SnippetVarValue;
use Yii;
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

    public function parseMasterContent()
    {
        $pages = $command = (new Query())
            ->select('*')
            ->from('page')
            ->createCommand()
            ->queryAll();

        foreach ($pages as $page)
        {
            $rowIds = explode(',', $page['layout_poradie_id']);

            $rowWidth = explode(',', $page['layout_poradie']);

            $section = Section::findOne(['page_id' => $page['id']]);

            for ($i = 0; $i < sizeof($rowIds); $i++) //loop through rows
            {
                $row = new Row();

                $row->section_id = $section;

                if ($row->validate())
                {
                    $row->save();
                }
                else
                {
                    BaseVarDumper::dump($row->errors);
                }

                $columns = json_decode($page['layout_element'], true)['content']['master'];

                foreach($columns as $columnId => $columnData)
                {
                    $column = new Column();
                    $column->row_id = $row->id;
                }

            }
        }

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
        }
    }

    /** Parsovanie dat z glob. hlavicky a paticky
     * @param $tableName string
     * @param $dataType string
     * @throws \yii\db\Exception
     */
    public function parsePageGlobalSection($tableName, $dataType)
    {
        $result = $command = (new Query())
            ->select('*')
            ->from($tableName)
            ->where('id < 438')
            ->createCommand()
            ->queryAll();

        foreach($result as $tableRow)
        {
            VarDumper::dump($tableRow['id']);

            if ($tableRow['sekcia_settings'] == '' || $tableRow['layout_element'] == '')
                continue;

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

            foreach ($sectionsLayoutElement as $sectionId => $sectionData)
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

                    foreach ($sectionData as $columnId => $columnData)
                    {
                        $rowId = intval(substr($columnId, 1));

                        $row = Row::findOne(['id' => $rowId]);

                        if ($row == NULL)
                            $row = new Row();

                        $row->section_id = $section->id;

                        if ($row->validate())
                        {
                            $row->save();
                        }
                        else
                        {
                            BaseVarDumper::dump($row->errors);
                        }

                        $column = new Column();

                        $column->row_id = $row->id;
                        $column->order = substr($columnId, 0, 1);

                        if ($column->validate())
                        {
                            $column->save();
                        }
                        else
                        {
                            BaseVarDumper::dump($column->errors);
                        }

                        foreach ($columnData as $tempId => $snippetCodeId)
                        {
                            $pageBlockType = $sectionsLayoutElementType[$sectionId][$columnId][$tempId];

                            $pageBlock = new PageBlock();

                            $pageBlock->column_id = $column->id;
                            $pageBlock->active = $sectionsLayoutElementActive[$sectionId][$columnId][$tempId];

                            switch($pageBlockType)
                            {
                                case 'smart_snippet' :

                                    $json = json_decode($sectionsJsonSmartsnippet[$sectionId][$columnId][$tempId], true);

                                    $pageBlock->type = 'snippet';

                                    if (!isset($json['snippet']) || !isset($json['code_select']) || !is_array($json['snippet']))
                                        continue;

                                    $snippetCode = SnippetCode::findOne(['id' => $json['code_select']]);

                                    if ($snippetCode == NULL)
                                        continue;

                                    $pageBlock->snippet_code_id = $json['code_select'];

                                    $pageBlock->data = json_encode($json['snippet']);

                                    break;

                                case 'html' :

                                    $pageBlock->type = 'html';
                                    $pageBlock->snippet_code_id = NULL;
                                    $pageBlock->data = json_encode(
                                        $sectionsLayoutElement[$sectionId][$columnId][$tempId], true
                                    );

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
                catch (Exception $e)
                {
                    VarDumper::dump($e);
                }
            }
            //die();
        }
    }

    /** Parsovanie dat vyplnenych snippetov z JSONU do tabulky snippet_var_value
     * @throws \yii\db\Exception
     */
    public function parseSnippetVarValues()
    {
        $pageBlocks = PageBlock::findAll(['type' => 'snippet']);

        $transaction = Yii::$app->db->beginTransaction();

        foreach($pageBlocks as $pageBlock)
        {
            $data = $pageBlock->data;

            if ($data == '[]')
                continue;

            $json = (object)(json_decode($data));

            foreach($json as $key => $value)
            {
                /* @var $snippetVar SnippetVar */
                $snippetVar = SnippetVar::findOne([
                    'identifier' => $key,
                    'snippet_id' => $pageBlock->snippetCode->snippet_id]);

                $snippetVarValue = new SnippetVarValue();

                $snippetVarValue->page_block_id = $pageBlock->id;
                $snippetVarValue->var_id = $snippetVar->id;

                switch($snippetVar->type->identifier)
                {
                    case 'list':
                        $snippetVarValue->value_list_id = $this->parseSnippetList($value, $pageBlock);

                        break;
                    case 'page':

                        $page = Page::findOne(['id' => substr($value, 8)]);

                        $snippetVarValue->value_page_id = $page->id;

                        break;

                    case 'product':

                        $product = Product::findOne(['identifier' => $value]);

                        $snippetVarValue->value_product_id = $product->id;

                        break;
                    case 'tag':

                        break;
                    default:
                        $snippetVarValue->value_text = $value;
                }

                $snippetVarValue->save();
            }
            $transaction->commit();
            //$transaction->rollBack();

            die();
        }
    }

    /** Pomocna metoda pre parsovanie zoznamov - rekurzivne sa vola pre zoznamy nizsich urovni
     * @param $value - cast jsonu, z ktorej sa parsuju data
     * @param $pageBlock PageBlock - blok, ktoreho sa zoznamy tykaju
     * @return int
     */
    private function parseSnippetList($value, PageBlock $pageBlock)
    {
        $list = new ListVar();
        $list->save();

        foreach($value as $item)
        {
            $listItem = new ListItem();
            $listItem->active = $item->active;
            $listItem->list_id = $list->id;

            $listItem->save();

            foreach($item as $itemVarIdentifier => $itemVarValue)
            {
                /* @var $snippetListVar SnippetVar */
                $snippetListVar = SnippetVar::findOne([
                    'identifier' => $itemVarIdentifier,
                    'snippet_id' => $pageBlock->snippetCode->snippet_id]);

                if ($snippetListVar != null)
                {
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

                            $snippetListVarValue->value_page_id = $page->id;

                            break;

                        case 'product':

                            $product = Product::findOne(['identifier' => $itemVarValue]);

                            $snippetListVarValue->value_product_id = $product->id;

                            break;
                        case 'tag':

                            break;
                        default:
                            $snippetListVarValue->value_text = $itemVarValue;
                    }

                    //BaseVarDumper::dump($snippetListVarValue, 10, true);

                    $snippetListVarValue->validate(null, false);

                    BaseVarDumper::dump($snippetListVarValue->getErrors());

                    $snippetListVarValue->save();
                }
            }
        }

        return $list->id;
    }

}