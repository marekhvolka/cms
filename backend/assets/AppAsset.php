<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css',
        'css/theme.css',
        'css/site.css',
        'https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.1/dragula.min.css',
    ];
    public $js = [
        'js/menu.js',
        'js/global-search.js',
        'https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.1/dragula.min.js',
        'http://www.papercut.com/products/free-software/are-you-sure/jquery.are-you-sure.js',
        'js/common.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}
