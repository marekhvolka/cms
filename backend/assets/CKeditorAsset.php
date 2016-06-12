<?php

namespace backend\assets;

use yii\web\AssetBundle;

class CKEditorAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'ckeditor/ckeditor.js',
        'http://www.hyperfinance.cz/js/bootstrap.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset'
    ];
}
