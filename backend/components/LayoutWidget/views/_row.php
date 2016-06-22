<?php
use yii\helpers\BaseHtml;

/* @var $model backend\models\Row */
/* @var $indexSection int */
/* @var $indexRow int */

if (!isset($indexRow))
    $indexRow = rand(100, 1000000);
?>

<!--ROW TO ADD-->
<div class="row layout-row">
    <?= BaseHtml::hiddenInput("Section[$indexSection][Row][$indexRow][existing]", $model->isNewRecord ? 'false' : 'true', ['class' => 'existing']); ?>
    <?= BaseHtml::hiddenInput("Section[$indexSection][Row][$indexRow][id]", $model->id, ['class' => 'id']); ?>
    <?= BaseHtml::hiddenInput("Section[$indexSection][Row][$indexRow][section_id]", $model->section_id, ['class' => 'section_id']); ?>
    <?= BaseHtml::hiddenInput("Section[$indexSection][Row][$indexRow][order]", $model->order, ['class' => 'order']); ?>
    <?php foreach ($model->columns as $indexColumn => $column) : ?>
        <?= $this->render('_column', [
            'model' => $column,
            'indexSection' => $indexSection,
            'indexRow' => $indexRow,
            'indexColumn' => $indexColumn
        ]); ?>
    <?php endforeach; ?>
</div>
