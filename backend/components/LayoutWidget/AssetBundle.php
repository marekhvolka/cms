<?php

/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 15.05.16
 * Time: 1:13
 */

namespace backend\components\LayoutWidget;

class AssetBundle extends \yii\web\AssetBundle
{
    // Disables assets caching.
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $css = [
        'css/style.css'
    ];
    public $js = [
        'js/layout.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'backend\components\BlockModal\AssetBundle',
        'backend\assets\CKEditorAsset',
    ];

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->sourcePath = __DIR__ . "/assets";
    }

}
