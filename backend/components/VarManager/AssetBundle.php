<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 15.05.16
 * Time: 1:13
 */

namespace backend\components\VarManager;


class AssetBundle extends \yii\web\AssetBundle
{
    public $css = [
        'css/style.css'
    ];

    public $js = [
        'js/variable.js'
    ];

    public $depends = [
        'backend\components\BlockModal\AssetBundle',
    ];

    public function init()
    {
        parent::init();
        $this->sourcePath = __DIR__ . "/assets";
    }
}