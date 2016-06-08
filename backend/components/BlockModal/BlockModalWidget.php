<?php

namespace backend\components\BlockModal;
use backend\models\Block;
use yii\bootstrap\Widget;

/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 06.06.16
 * Time: 10:56
 */
class BlockModalWidget extends Widget
{
    public $block;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        AssetBundle::register($this->getView());

        /*return $this->render('view', [
            'model' => $this->block,
        ]);*/
    }

    /** Renders view for one appended variable.
     * @param $block Block
     * @return string
     */
    public function appendModal($block)
    {
        return $this->render('view', [
            'model' => $block,
        ]);
    }
}