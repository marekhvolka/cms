<?php

namespace backend\components\ToggleSwitch;

use yii\bootstrap\Widget;

/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 06.06.16
 * Time: 10:56
 */
class ToggleSwitchWidget extends Widget
{
    public $name;
    public $value;
    public $trueItem;
    public $falseItem;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        ToggleSwitchAsset::register($this->getView());

        return $this->render('view', [
            'trueItem' => $this->trueItem,
            'falseItem' => $this->falseItem,
            'name' => $this->name,
            'value' => $this->value
        ]);
    }
}