<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use backend\components\FileEditor\FileEditorWidget;

/* @var $this yii\web\View */
/* @var $fileEditor \backend\components\FileEditor\FileEditorWidget */

$this->title = 'Editovať súbory šablóny';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="edit-files" style="margin-left: -20px">
    <?php $fileEditor->display() ?>
</div>
