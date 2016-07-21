<?php

use backend\models\Template;

/* @var $this yii\web\View */
/* @var $fileEditor \backend\components\FileEditor\FileEditorWidget */
/* @var $model Template */

$this->title = 'Editovať súbory šablóny';
$this->params['breadcrumbs'][] = $model->name;
?>

<div class="edit-files" style="margin-left: -20px">
    <?php $fileEditor->display() ?>
</div>
