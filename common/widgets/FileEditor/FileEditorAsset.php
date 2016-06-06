<?php
namespace common\widgets\FileEditor;

use yii\web\AssetBundle;

/**
 * Registers all assets required by the FileEditor.
 * 
 * @package common\widgets\FileEditor
 */
class FileEditorAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/web';
    public $css = [
        'css/file-editor.css',
    ];
    public $js = [
        'js/file-editor.js'
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}