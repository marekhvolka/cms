<?php

namespace backend\components\LayoutWidget;

use yii\base\Widget;
use yii\helpers\Html;
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
        ]);
    }

    /** Renders view for one appended section.
     * @return string
     */
    public function appendSection()
    {
        return $this->render('_section', ['section' => new Section()]);
    }

    /** Renders view for one appended rpw.
     * @return string
     */
    public function appendRow($columnsWidth, $sectionId)
    {
        if (!$columnsWidth) {
            return false;
        }
        
        $row = new Row();
        $row->section_id = $sectionId;
        $columns = [];

        foreach ($columnsWidth as $i => $width) {
            $column = new Column();
            $column->width = $width;
            $column->row_id = $row->id;
            $column->order = $i;
            $columns[] = $column;
        }
        
        return $this->render('_row', ['row' => $row, 'columns' => $columns]);
    }

    /** Renders view for one appended section.
     * @return string
     */
    public function appendBlock($columnId)
    {
        $block = new Block();
        $block->column_id = $columnId;
        $block->data = 'test'; // TODO test data.
        $block->type = 'text'; // TODO test data.
        return $this->render('_block', ['block' => $block]);
    }

}
