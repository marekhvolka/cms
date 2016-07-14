<?php
use backend\models\Page;
use backend\models\Portal;
use yii\bootstrap\Html;
use yii\helpers\Url;

/** @var $portal Portal */
/** @var $page Page */
?>

<div class="cms-top-bar" xmlns:Html="http://www.w3.org/1999/html">
    Prihlásený ako <?= Yii::$app->user->getIdentity()->username ?>.

    <div class="pull-right">
    <?= Html::a('Upraviť podstránku', '/backend/web/page/edit/' . $page->id) ?>
    <?= $page->product ?
        Html::a('Upraviť produkt', '/backend/web/product/edit/' . $page->product->id) : '' ?>
    </div>
</div>