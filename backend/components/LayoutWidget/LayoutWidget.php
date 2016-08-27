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
    public $layoutOwner;
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
            'layoutOwner' => $this->layoutOwner,
            'portal' => $this->portal,
            'prefix' => $this->area->type
        ]);
    }

    /** Renders view for one appended section.
     * @param Section $section
     * @param $prefix
     * @param int $indexSection
     * @param $layoutOwner
     * @param $portal
     * @return string
     */
    public function appendSection(Section $section, $prefix, $indexSection, $layoutOwner, $portal)
    {
        return $this->render('_section', [
            'model' => $section,
            'prefix' => $prefix . "[$indexSection]",
            'layoutOwner' => $layoutOwner,
            'portal' => $portal,
        ]);
    }

    /** Renders view for one appended row.
     * @param Row $row
     * @param $prefix
     * @param $indexRow
     * @param $layoutOwner
     * @param $portal
     * @return string
     */
    public function appendRow(Row $row, $prefix, $indexRow, $layoutOwner, $portal)
    {
        return $this->render('_row', [
            'model' => $row,
            'prefix' => $prefix . "[Row][$indexRow]",
            'layoutOwner' => $layoutOwner,
            'portal' => $portal,
        ]);
    }

    /** Renders view for one appended column.
     * @param Column $column
     * @param $prefix
     * @param $indexColumn
     * @param $layoutOwner
     * @param $portal
     * @return string
     */
    public function appendColumn(Column $column, $prefix, $indexColumn, $layoutOwner, $portal)
    {
        return $this->render('_column', [
            'model' => $column,
            'prefix' => $prefix . "[Column][$indexColumn]",
            'layoutOwner' => $layoutOwner,
            'portal' => $portal,
        ]);
    }

    /** Renders view for one appended section.
     * @param Block $block
     * @param $prefix
     * @param $indexBlock
     * @param $layoutOwner
     * @param $portal
     * @return string
     */
    public function appendBlock(Block $block, $prefix, $indexBlock, $layoutOwner, $portal)
    {
        return $this->render('_block', [
            'model' => $block,
            'prefix' => $prefix . "[Block][$indexBlock]",
            'renderModal' => true,
            'layoutOwner' => $layoutOwner,
            'portal' => $portal,
        ]);
    }
}