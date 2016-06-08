<?php

namespace backend\assets;

use yii\web\AssetBundle;

class FancyBoxAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'fancybox/jquery.fancybox.css',
    ];
    public $js = [
        'fancybox/jquery.fancybox.pack.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
