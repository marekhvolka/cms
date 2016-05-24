<?php
/**
 * Created by PhpStorm.
 * User: juraj
 * Date: 24/05/16
 * Time: 16:33
 */

namespace common\widgets\FileEditor;


use yii\web\AssetBundle;

class FileEditorAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/web';
    public $css = [
        'css/jQueryFileTree.min.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}