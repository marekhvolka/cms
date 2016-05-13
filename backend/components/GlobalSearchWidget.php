<?php

namespace backend\components;

use yii\base\Widget;


class GlobalSearchWidget extends Widget
{
    public $searchTerm;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('globalSearchWidget',[

        ]);
    }

}
