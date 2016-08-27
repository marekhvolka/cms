<?php

namespace backend\components\MultipleSwitch;

use yii\bootstrap\Widget;

/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 06.06.16
 * Time: 10:56
 */
class MultipleSwitchWidget extends Widget
{
    public $items;
    public $name;
    public $value;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        MultipleSwitchAsset::register($this->getView());

        return $this->render('view', [
            'items' => $this->items,
            'name' => $this->name,
            'value' => $this->value
        ]);
    }
}