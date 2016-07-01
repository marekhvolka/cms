<?php

namespace backend\components\MultimediaWidget;

use backend\models\MultimediaCategory;
use yii\base\Widget;

/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 29.06.16
 * Time: 14:44
 */
class MultimediaWidget extends Widget
{
    public $path;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        MultimediaWidgetAsset::register($this->getView());

        return $this->render('view', [
            'categories' => MultimediaCategory::loadAll()
        ]);
    }
}