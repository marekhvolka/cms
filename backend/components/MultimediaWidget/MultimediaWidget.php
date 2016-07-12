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
    public $renderAsModal = false;
    public $onlyItems = false;
    public $onlyImages = false;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $categories = MultimediaCategory::loadAll();

        if ($this->onlyItems) {
            return $this->render('_items', ['categories' => $categories, 'onlyImages' => $this->onlyImages]);
        }

        MultimediaWidgetAsset::register($this->getView());

        return $this->render($this->renderAsModal ? 'view-modal' : 'view', [
            'categories' => $categories,
            'modal' => $this->renderAsModal,
            'onlyImages' => $this->onlyImages
        ]);
    }
}