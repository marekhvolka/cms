<?php
use yii\helpers\BaseHtml;

/* @var $model backend\models\Row */
/* @var $prefix string */

?>

<div class="row layout-row" data-prefix="<?= $prefix ?>">
    <?= BaseHtml::hiddenInput($prefix . "[existing]", $model->isNewRecord ? 'false' : 'true', ['class' => 'existing']); ?>
    <?= BaseHtml::hiddenInput($prefix . "[id]", $model->id, ['class' => 'id']); ?>
    <?= BaseHtml::hiddenInput($prefix . "[section_id]", $model->section_id, ['class' => 'section_id']); ?>
    <?= BaseHtml::hiddenInput($prefix . "[order]", $model->order, ['class' => 'order']); ?>
    <div class="children-list">
        <?php foreach ($model->columns as $indexColumn => $column) : ?>
            <?= $this->render('_column', [
                'model' => $column,
                'prefix' => $prefix . "[Column][$indexColumn]"
            ]); ?>
        <?php endforeach; ?>
    </div>
</div>
