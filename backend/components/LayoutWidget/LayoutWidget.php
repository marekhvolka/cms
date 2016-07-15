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
    public $page;
    public $portal;

    public $allowAddingSection = true;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('layoutWidget', [
            'area' => $this->area,
            'controllerUrl' => $this->controllerUrl,
            'formId' => $this->formId,
            'allowAddingSection' => $this->allowAddingSection,
            'page' => $this->page,
            'portal' => $this->portal,
            'prefix' => $this->area->type
        ]);
    }

    /** Renders view for one appended section.
     * @param Section $section
     * @param $prefix
     * @param int $indexSection
     * @param $page
     * @param $portal
     * @return string
     */
    public function appendSection(Section $section, $prefix, $indexSection, $page, $portal)
    {
        return $this->render('_section', [
            'model' => $section,
            'prefix' => $prefix . "[$indexSection]",
            'page' => $page,
            'portal' => $portal,
        ]);
    }

    /** Renders view for one appended row.
     * @param Row $row
     * @param $prefix
     * @param $indexRow
     * @param $page
     * @param $portal
     * @return string
     */
    public function appendRow(Row $row, $prefix, $indexRow, $page, $portal)
    {
        return $this->render('_row', [
            'model' => $row,
            'prefix' => $prefix . "[Row][$indexRow]",
            'page' => $page,
            'portal' => $portal,
        ]);
    }

    /** Renders view for one appended column.
     * @param Column $column
     * @param $prefix
     * @param $indexColumn
     * @param $page
     * @param $portal
     * @return string
     */
    public function appendColumn(Column $column, $prefix, $indexColumn, $page, $portal)
    {
        return $this->render('_column', [
            'model' => $column,
            'prefix' => $prefix . "[Column][$indexColumn]",
            'page' => $page,
            'portal' => $portal,
        ]);
    }

    /** Renders view for one appended section.
     * @param Block $block
     * @param $prefix
     * @param $indexBlock
     * @param $page
     * @param $portal
     * @return string
     */
    public function appendBlock(Block $block, $prefix, $indexBlock, $page, $portal)
    {
        return $this->render('_block', [
            'model' => $block,
            'prefix' => $prefix . "[Block][$indexBlock]",
            'renderModal' => true,
            'page' => $page,
            'portal' => $portal,
        ]);
    }

}
