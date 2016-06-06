<?php
/**
 * Created by PhpStorm.
 * User: juraj
 * Date: 24/05/16
 * Time: 16:33
 */

namespace backend\components\FileEditor;


use yii\web\AssetBundle;

class FileEditorAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/web';
    public $css = [
        'css/jQueryFileTree.css',
    ];
    public $js = [
        'js/file-editor.js'
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}