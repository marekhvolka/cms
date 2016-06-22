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
        ]);
    }

    /** Renders view for one appended section.
     * @param Section $section
     * @param int $indexSection
     * @return string
     */
    public function appendSection(Section $section)
    {
        return $this->render('_section', [
            'model' => $section,
        ]);
    }

    /** Renders view for one appended row.
     * @param Row $row
     * @param $indexSection
     * @return string
     * @internal param $indexRow
     */
    public function appendRow(Row $row, $indexSection)
    {
        return $this->render('_row', [
            'model' => $row,
            'indexSection' => $indexSection,
        ]);
    }

    /** Renders view for one appended column.
     * @param Column $column
     * @param $indexSection
     * @param $indexRow
     * @return string
     */
    public function appendColumn(Column $column, $indexSection, $indexRow)
    {
        return $this->render('_column', [
            'model' => $column,
            'indexSection' => $indexSection,
            'indexRow' => $indexRow,
        ]);
    }

    /** Renders view for one appended section.
     * @param Block $block
     * @return string
     */
    public function appendBlock(Block $block, $indexSection, $indexRow, $indexColumn)
    {
        return $this->render('_block', [
            'block' => $block,
            'indexSection' => $indexSection,
            'indexRow' => $indexRow,
            'indexColumn' => $indexColumn
        ]);
    }

}
