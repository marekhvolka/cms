<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 15.05.16
 * Time: 1:13
 */

namespace backend\components\BlockModal;

use yii\web\View;

class AssetBundle extends \yii\web\AssetBundle
{
    public $css = [
        'css/style.css'
    ];

    public $js = [
        'js/modal.js'
    ];

    public $depends = [
        'yii\jui\JuiAsset',
        'backend\assets\AppAsset',
        'kartik\select2\Select2Asset',
        'kartik\color\ColorInputAsset',
        'trntv\aceeditor\AceEditorAsset',
        'backend\assets\CKEditorAsset',
    ];

    public function init()
    {
        parent::init();
        $this->sourcePath = __DIR__ . "/assets";
    }

}