<?php
use backend\models\Portal;
use yii\bootstrap\Html;

/** @var $portal Portal */
?>

<div class="cms-top-bar">
    Prihlásený ako <?= Yii::$app->user->getIdentity()->username ?>.
</div>