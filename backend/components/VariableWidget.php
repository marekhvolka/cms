<?php

namespace backend\components;

use yii\base\Widget;
use yii\helpers\Html;

class VariableWidget extends Widget
{

    public $message;

    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = 'Hello World';
        }
    }

    public function run()
    {
        return $this->render('variableWidget',['message' => $this->message]);
    }

}
