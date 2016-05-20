<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 15.05.16
 * Time: 1:13
 */

namespace backend\components\VarManager2;


class AssetBundle extends \yii\web\AssetBundle
{
    public $basePath = '@app/components/LayoutWidget/assets';

    public $css = [
        'css/style.css'
    ];

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub

        $this->sourcePath = __DIR__ . "/assets";
    }

}