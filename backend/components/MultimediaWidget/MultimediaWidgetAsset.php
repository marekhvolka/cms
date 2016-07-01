<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 15.05.16
 * Time: 1:13
 */

namespace backend\components\MultimediaWidget;


use yii\web\AssetBundle;

class MultimediaWidgetAsset extends AssetBundle
{
    public $sourcePath = __DIR__. '/web';

    public $css = [
        'css/style.css'
    ];

    public $js = [
        'js/multimedia.js'
    ];

    public $depends = [
        'backend\assets\FancyBoxAsset',
        'yii\web\JqueryAsset'
    ];
}