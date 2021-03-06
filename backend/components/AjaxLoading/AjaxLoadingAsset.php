<?php
namespace backend\components\AjaxLoading;

use yii\web\AssetBundle;

/**
 * Registers all assets required by the AjaxLoadingWidget.
 *
 * @package backend\component\FileEditor
 */
class AjaxLoadingAsset extends AssetBundle
{
    //public $sourcePath = '' . __DIR__ . '/web';   // Error here.
    public $css = [
        'css/ajax-loader.css',
    ];
    public $js = [
        'js/ajax-loader.js'
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
    
    public function init()
    {
        parent::init();
        $this->sourcePath = __DIR__ . "/web";
    }
}