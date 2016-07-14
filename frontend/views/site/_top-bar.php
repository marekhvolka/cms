<?php
use backend\models\Page;
use backend\models\Portal;
use yii\bootstrap\Html;

/** @var $portal Portal */
/** @var $page Page */
?>

<div class="cms-top-bar">
    Prihlásený ako <?= Yii::$app->user->getIdentity()->username ?>.

    <div class="pull-right">
        <?= Html::a('Upraviť podstránku', '/backend/web/page/edit/' . $page->id, [
            'target' => '_blank'
        ]) ?>
        <?= $page->product ?
            Html::a('Upraviť produkt', '/backend/web/product/edit/' . $page->product->id, [
                'target' => '_blank'
            ]) : '' ?>
    </div>
</div>