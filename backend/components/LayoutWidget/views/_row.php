<?php
use yii\helpers\BaseHtml;

/* @var $model backend\models\Row */

$postIndex = $model->id ? $model->id : rand(0, 10000000); // Index for correctly indexing Post request variable.
?>

<!--ROW TO ADD-->
<div class="row layout-row">
    <?php $model->id = $model->id ? : $postIndex ?>
    <?= BaseHtml::hiddenInput("Row[$postIndex][existing]", $model->isNewRecord ? 'false' : 'true', ['class' => 'existing']); ?>
    <?= BaseHtml::hiddenInput("Row[$postIndex][id]", $postIndex, ['class' => 'id']); ?>
    <?= BaseHtml::hiddenInput("Row[$postIndex][section_id]", $model->section_id, ['class' => 'section_id']); ?>
    <?= BaseHtml::hiddenInput("Row[$postIndex][order]", $model->order, ['class' => 'order']); ?>
    <?php foreach ($model->columns as $column) : ?>
        <?= $this->render('_column', ['model' => $column]); ?>
    <?php endforeach; ?>
</div>
