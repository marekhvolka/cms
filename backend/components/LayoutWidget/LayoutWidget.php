<?php

namespace backend\components\LayoutWidget;

use yii\base\Widget;
use backend\models\Section;
use backend\models\Row;
use backend\models\Column;
use backend\models\Block;

/**
 * Widget for layout features - section, rows, columns functionality.
 */
class LayoutWidget extends Widget
{
    public $controllerUrl;
    public $sections;
    public $type;
    public $formId;
    public $prefix;
    public $productType;

    public $allowAddingSection = true;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        AssetBundle::register($this->getView());

        return $this->render('layoutWidget', [
            'sections' => $this->sections,
            'controllerUrl' => $this->controllerUrl,
            'type' => $this->type,
            'formId' => $this->formId,
            'prefix' => $this->prefix,
            'allowAddingSection' => $this->allowAddingSection,
            'productType' => $this->productType
        ]);
    }

    /** Renders view for one appended section.
     * @param Section $section
     * @param $prefix
     * @param int $indexSection
     * @return string
     */
    public function appendSection(Section $section, $prefix, $indexSection, $productType)
    {
        return $this->render('_section', [
            'model' => $section,
            'prefix' => $prefix . "[$indexSection]",
            'productType' => $productType
        ]);
    }

    /** Renders view for one appended row.
     * @param Row $row
     * @param $prefix
     * @param $indexRow
     * @return string
     */
    public function appendRow(Row $row, $prefix, $indexRow, $productType)
    {
        return $this->render('_row', [
            'model' => $row,
            'prefix' => $prefix . "[Row][$indexRow]",
            'productType' => $productType
        ]);
    }

    /** Renders view for one appended column.
     * @param Column $column
     * @param $prefix
     * @param $indexColumn
     * @return string
     */
    public function appendColumn(Column $column, $prefix, $indexColumn, $productType)
    {
        return $this->render('_column', [
            'model' => $column,
            'prefix' => $prefix . "[Column][$indexColumn]",
            'productType' => $productType
        ]);
    }

    /** Renders view for one appended section.
     * @param Block $block
     * @param $prefix
     * @param $indexBlock
     * @param $productType
     * @return string
     */
    public function appendBlock(Block $block, $prefix, $indexBlock, $productType)
    {
        return $this->render('_block', [
            'model' => $block,
            'prefix' => $prefix . "[Block][$indexBlock]",
            'renderModal' => true,
            'productType' => $productType
        ]);
    }

}
