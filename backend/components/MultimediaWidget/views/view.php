<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 29.06.16
 * Time: 14:43
 */

use backend\components\MultimediaWidget\MultimediaWidgetAsset;

MultimediaWidgetAsset::register($this);
?>

<div class="company-crossing">
    <ul class="nav nav-tabs">
        <li role="presentation" class="tab-label active">
            <a href="#tab_new" data-toggle="tab">Nahrať nový obrázok</a>
        </li>
        <li role="presentation" class="tab-label">
            <a href="#tab_existing" data-toggle="tab">Použiť existujúci</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_new">
            <?= $this->render('_new')?>
        </div>
        <div class="tab-pane" id="tab_existing">
            <?= $this->render('_existing', ['categories' => $categories])?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
