<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $fileEditor \common\widgets\FileEditor\FileEditorWidget */

$this->title = 'Editovať súbory šablóny';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="edit-files">
    <?php $fileEditor->display() ?>
</div>
