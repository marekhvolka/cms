<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 10.05.16
 * Time: 21:52
 */

namespace common\components;


use backend\models\ListItem;
use backend\models\ListVar;
use backend\models\Page;
use backend\models\PageBlock;
use backend\models\Product;
use backend\models\SnippetVar;
use backend\models\SnippetVarValue;
use Yii;
use yii\helpers\BaseVarDumper;
use yii\helpers\VarDumper;

class ParseEngine
{
    /** Metoda na presun dat z tabuliek product_snippet a portal_snippet do tabuliek page_block
     * @param $type
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

            $section = Yii::$app->db->createCommand('SELECT * FROM section WHERE page_id=:page_id',
                [':page_id' => $page['id']])
                ->queryOne();

            for ($i = 0; $i < sizeof($rowIds); $i++) //loop through rows
            {
                $command = Yii::$app->db->createCommand('INSERT IGNORE INTO row
                        (section_id, id)
                        VALUES(:section_id, :id)');

                $command->bindValue(':section_id', $section['id']);
                $command->bindValue(':id', $rowIds[$i]);

                $command->execute();
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

    public function parsePageGlobalSection($tableName, $dataType)
    {
        $command = (new Query())
            ->createCommand()
            ->delete('section');

        $result = $command = (new Query())
            ->select('*')
            ->from($tableName)
            ->createCommand()
            ->queryAll();

        foreach($result as $tableRow)
        {
            if ($tableRow['sekcia_settings'] == '')
                continue;

            if (isset(json_decode($tableRow['layout_element'], true)['header']))
                $type = 'header';
            else if (isset(json_decode($tableRow['layout_element'], true)['footer']))
                $type = 'footer';

            $sectionsLayoutElement = json_decode($tableRow['layout_element'], true)[$type];
            $sectionsCssSettings = json_decode($tableRow['sekcia_settings'], true)[$type];
            $sectionsBlockPoradie = json_decode($tableRow['block_poradie'], true)[$type];
            $sectionsLayoutElementActive = json_decode($tableRow['layout_element_active'], true)[$type];
            $sectionsLayoutElementTimeFrom = json_decode($tableRow['layout_element_time_from'], true)[$type];
            $sectionsLayoutElementTimeTo = json_decode($tableRow['layout_element_time_to'], true)[$type];
            $sectionsJsonSmartsnippet = json_decode($tableRow['json_smart_snippet'], true)[$type];
            $sectionsBlockSettings = json_decode($tableRow['block_settings'], true)[$type];

            foreach ($sectionsLayoutElement as $sectionId => $section)
            {
                try
                {
                    $command = Yii::$app->db->createCommand('INSERT IGNORE INTO section
                        (page_id, portal_id, id, type, css_style, css_class, css_id)
                        VALUES(:page_id, :portal_id, :id, :type, :css_style, :css_class, :css_id)');

                    if ($dataType == 'page')
                    {
                        $command->bindValue(':page_id', $tableRow['page_id']);
                        $command->bindValue(':portal_id', NULL);
                    }
                    else if ($dataType == 'portal')
                    {
                        $command->bindValue(':portal_id', $tableRow['portal_id']);
                        $command->bindValue(':page_id', NULL);
                    }

                    $command->bindValue(':id', $sectionId);
                    $command->bindValue(':type', $type);
                    $command->bindValue(':css_style', json_decode($sectionsCssSettings[$sectionId], true)['style_sett']);
                    $command->bindValue(':css_class', json_decode($sectionsCssSettings[$sectionId], true)['class_sett']);
                    $command->bindValue(':css_id', json_decode($sectionsCssSettings[$sectionId], true)['id_sett']);

                    $command->execute();

                    foreach ($section as $rowId => $row)
                    {
                        $command = Yii::$app->db->createCommand('INSERT IGNORE INTO row
                        (section_id, id)
                        VALUES(:section_id, :id)');

                        $command->bindValue(':section_id', $sectionId);
                        $command->bindValue(':id', $rowId);

                        $command->execute();

                        foreach ($row as $tempId => $snippetCodeId)
                        {
                            $json = json_decode($sectionsJsonSmartsnippet[$sectionId][$rowId][$tempId], true);

                            //VarDumper::dump($json);

                            if (!isset($json['snippet']) || !is_array($json['snippet']))
                                continue;

                            $command = Yii::$app->db->createCommand('INSERT IGNORE INTO page_block
                                (column_id, data, active, snippet_code_id, type)
                                VALUES(:column_id, :data, :active, :snippet_code_id, \'snippet\')');

                            $command->bindValue(':snippet_code_id', $json['code_select']);
                            $command->bindValue(':column_id', NULL);
                            $command->bindValue(':data', json_encode($json['snippet']));
                            $command->bindValue(':active', $sectionsLayoutElementActive[$sectionId][$rowId][$tempId]);

                            $command->execute();
                        }

                    }

                }
                catch (Exception $e)
                {
                    VarDumper::dump($e);
                }
            }
        }
    }

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

    private function parseSnippetList($value, $pageBlock)
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