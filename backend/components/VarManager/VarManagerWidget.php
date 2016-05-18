<?php

namespace backend\components\VarManager;

use yii\base\Widget;

class VarManagerWidget extends Widget
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
