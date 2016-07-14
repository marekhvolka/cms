<?php

namespace backend\components\AceEditor;

use yii\web\AssetBundle;

/**
 * Registers all assets required by the FileEditor.
 *
 * @package backend\component\FileEditor
 */
class AceEditorAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/ace-builds/src-min-noconflict';
    /**
     * @inheritdoc
     */
    public $js = [
        'ace.js'
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset'
    ];

    /**
     * @param \yii\web\View $view
     * @param array $extensions
     * @return static
     */
    public static function register($view, $extensions = [])
    {
        $bundle = parent::register($view);
        foreach ($extensions as $_ext) {
            $view->registerJsFile($bundle->baseUrl . "/ext-{$_ext}.js", ['depends' => [static::className()]], "ACE_EXT_" . $_ext);
        }
        return $bundle;
    }
}