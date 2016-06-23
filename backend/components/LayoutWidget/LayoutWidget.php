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
    public $portalId;
    public $pageId;
    public $formId;

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
            'portalId' => $this->portalId,
            'pageId' => $this->pageId,
            'formId' => $this->formId,
            'prefix' => ''
        ]);
    }

    /** Renders view for one appended section.
     * @param Section $section
     * @param $prefix
     * @param int $indexSection
     * @return string
     */
    public function appendSection(Section $section, $prefix, $indexSection)
    {
        return $this->render('_section', [
            'model' => $section,
            'prefix' => $prefix . "Section[$indexSection]"
        ]);
    }

    /** Renders view for one appended row.
     * @param Row $row
     * @param $prefix
     * @param $indexRow
     * @return string
     * @internal param $indexSection
     */
    public function appendRow(Row $row, $prefix, $indexRow)
    {
        return $this->render('_row', [
            'model' => $row,
            'prefix' => $prefix . "[Row][$indexRow]",
        ]);
    }

    /** Renders view for one appended column.
     * @param Column $column
     * @param $prefix
     * @param $indexColumn
     * @return string
     */
    public function appendColumn(Column $column, $prefix, $indexColumn)
    {
        return $this->render('_column', [
            'model' => $column,
            'prefix' => $prefix . "[Column][$indexColumn]",
        ]);
    }

    /** Renders view for one appended section.
     * @param Block $block
     * @param $prefix
     * @param $indexBlock
     * @return string
     */
    public function appendBlock(Block $block, $prefix, $indexBlock)
    {
        return $this->render('_block', [
            'model' => $block,
            'prefix' => $prefix . "[Block][$indexBlock]",
        ]);
    }

}
