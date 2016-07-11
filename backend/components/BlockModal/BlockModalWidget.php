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

    public $product;

    public $prefix;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        AssetBundle::register($this->getView());
        
        return $this->render('view', [
            'model' => $this->block,
            'product' => $this->product,
            'prefix' => $this->prefix
        ]);
    }

    /** Renders view for one appended variable.
     * @param $block Block
     * @param $prefix
     * @param $product
     * @return string
     */
    public function appendModal($block, $prefix, $product)
    {
        AssetBundle::register($this->getView());

        return $this->render('view', [
            'model' => $block,
            'product' => $product,
            'prefix' => $prefix
        ]);
    }

    public function appendListItem($listItem, $prefix, $indexItem, $product, $parentId)
    {
        return $this->render('_list-item', [
            'listItem' => $listItem,
            'prefix' => $prefix . "[ListItem][$indexItem]",
            'product' => $product,
            'parentId' => $parentId
        ]);
    }
}