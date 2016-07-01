<?php
namespace backend\components\FileEditor;

use yii\web\AssetBundle;

/**
 * Registers all assets required by the FileEditor.
 *
 * @package backend\component\FileEditor
 */
class FileEditorAsset extends AssetBundle
{
    public $sourcePath =  __DIR__ . '/web';
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