<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductType */
/* @var $fileEditor \backend\components\FileEditor\FileEditorWidget */

$this->title = 'Ďakovačky';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thanks">
    <?php $fileEditor->display() ?>
</div>
