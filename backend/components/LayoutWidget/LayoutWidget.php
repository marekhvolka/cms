<?php

namespace backend\components\LayoutWidget;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * Widget for layout features - section, rows, columns functionality.
 */
class LayoutWidget extends Widget
{
    public $sections;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        AssetBundle::register($this->getView());

        return $this->render('layoutWidget', [
            'sections' => $this->sections
        ]);
    }

}
