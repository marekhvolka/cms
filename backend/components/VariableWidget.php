<?php

namespace backend\components;

use yii\base\Widget;
use yii\helpers\Html;

class VariableWidget extends Widget
{
    public $type;
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('variableWidget', [
            'type' => $this->type,
            'model' => $this->model
        ]);
    }

}
