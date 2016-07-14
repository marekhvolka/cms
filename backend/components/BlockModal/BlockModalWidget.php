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

    public $page;
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
            'page' => $this->page,
            'portal' => $this->portal,
            'prefix' => $this->prefix
        ]);
    }

    /** Renders view for one appended variable.
     * @param $block Block
     * @param $prefix
     * @param $page
     * @param $portal
     * @return string
     */
    public function appendModal($block, $prefix, $page, $portal)
    {
        AssetBundle::register($this->getView());

        return $this->render('view', [
            'model' => $block,
            'page' => $page,
            'portal' => $portal,
            'prefix' => $prefix
        ]);
    }

    public function appendListItem($listItem, $prefix, $indexItem, $page, $portal, $parentId)
    {
        return $this->render('_list-item', [
            'listItem' => $listItem,
            'prefix' => $prefix . "[ListItem][$indexItem]",
            'page' => $page,
            'portal' => $portal,
            'parentId' => $parentId
        ]);
    }
}