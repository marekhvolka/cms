<?php
namespace backend\components\TreeGrid;

use yii\web\AssetBundle;

/**
 * Registers all assets required by the TreeGridWidget.
 *
 * @package backend\component\FileEditor
 */
class TreeGridAsset extends AssetBundle
{
    public $sourcePath = '' . __DIR__ . '/web';
    public $css = [
        'css/tree-grid.css',
    ];
    public $js = [
        'js/tree-grid.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}