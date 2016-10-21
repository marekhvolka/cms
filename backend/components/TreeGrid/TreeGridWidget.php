<?php

namespace backend\components\TreeGrid;

use yii\base\Widget;
use yii\helpers\Html;

class TreeGridWidget extends Widget
{
    public $rows;
    public $columns;

    public $childrenIdentifier;

    public function run()
    {
        return $this->render('main', [
            'rows' => $this->rows,
            'columns' => $this->columns,
            'childrenIdentifier' => $this->childrenIdentifier
        ]);
    }

}
