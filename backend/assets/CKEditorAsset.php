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
        'js/ckeditor-config.js',
        'js/ckeditor/plugin.js',
        'js/ckeditor/dialogs/custimage.js'
    ];
    public $depends = [
        'dosamigos\ckeditor\CKEditorAsset'
    ];
}
