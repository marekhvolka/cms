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

    public $layoutOwner;
    public $portal;

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
            'layoutOwner' => $this->layoutOwner,
            'portal' => $this->portal,
            'prefix' => $this->prefix
        ]);
    }

    /** Renders view for one appended variable.
     * @param $block Block
     * @param $prefix
     * @param $layoutOwner
     * @param $portal
     * @return string
     */
    public function appendModal($block, $prefix, $layoutOwner, $portal)
    {
        AssetBundle::register($this->getView());

        return $this->render('view', [
            'model' => $block,
            'layoutOwner' => $layoutOwner,
            'portal' => $portal,
            'prefix' => $prefix
        ]);
    }

    public function appendListItem($listItem, $prefix, $indexItem, $layoutOwner, $portal, $parentId)
    {
        return $this->render('_list-item', [
            'listItem' => $listItem,
            'prefix' => $prefix . "[ListItem][$indexItem]",
            'layoutOwner' => $layoutOwner,
            'portal' => $portal,
            'parentId' => $parentId
        ]);
    }
}