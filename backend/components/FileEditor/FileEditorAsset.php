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
    public $css = [
        'css/file-editor.css',
    ];
    public $js = [
        'js/file-editor.js',
        'https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js'
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