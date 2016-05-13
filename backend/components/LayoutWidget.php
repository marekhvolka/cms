<?php

namespace backend\components;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * Widget for layout features - section, rows, columns functionality.
 */
class LayoutWidget extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('layoutWidget');
    }

}
