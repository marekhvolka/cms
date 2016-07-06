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
    public $area;
    public $formId;
    public $product;

    public $allowAddingSection = true;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        AssetBundle::register($this->getView());

        return $this->render('layoutWidget', [
            'area' => $this->area,
            'controllerUrl' => $this->controllerUrl,
            'formId' => $this->formId,
            'allowAddingSection' => $this->allowAddingSection,
            'product' => $this->product,
            'prefix' => $this->area->type
        ]);
    }

    /** Renders view for one appended section.
     * @param Section $section
     * @param $prefix
     * @param int $indexSection
     * @param $product
     * @return string
     */
    public function appendSection(Section $section, $prefix, $indexSection, $product)
    {
        return $this->render('_section', [
            'model' => $section,
            'prefix' => $prefix . "[$indexSection]",
            'product' => $product
        ]);
    }

    /** Renders view for one appended row.
     * @param Row $row
     * @param $prefix
     * @param $indexRow
     * @param $product
     * @return string
     */
    public function appendRow(Row $row, $prefix, $indexRow, $product)
    {
        return $this->render('_row', [
            'model' => $row,
            'prefix' => $prefix . "[Row][$indexRow]",
            'product' => $product
        ]);
    }

    /** Renders view for one appended column.
     * @param Column $column
     * @param $prefix
     * @param $indexColumn
     * @param $product
     * @return string
     */
    public function appendColumn(Column $column, $prefix, $indexColumn, $product)
    {
        return $this->render('_column', [
            'model' => $column,
            'prefix' => $prefix . "[Column][$indexColumn]",
            'product' => $product
        ]);
    }

    /** Renders view for one appended section.
     * @param Block $block
     * @param $prefix
     * @param $indexBlock
     * @param $product
     * @return string
     */
    public function appendBlock(Block $block, $prefix, $indexBlock, $product)
    {
        return $this->render('_block', [
            'model' => $block,
            'prefix' => $prefix . "[Block][$indexBlock]",
            'renderModal' => true,
            'product' => $product
        ]);
    }

}
