<?php
use yii\helpers\BaseHtml;

/* @var $model backend\models\Row */
/* @var $prefix string */
/* @var $product \backend\models\Product */

?>

<div class="row layout-row" data-prefix="<?= $prefix ?>" data-product-id="<?= $product ? $product->id : '' ?>">
    <?= BaseHtml::hiddenInput($prefix . "[existing]", !$model->isNewRecord, ['class' => 'existing']); ?>
    <?= BaseHtml::hiddenInput($prefix . "[section_id]", $model->section_id, ['class' => 'section_id']); ?>
    <div class="children-list">
        <?php foreach ($model->columns as $indexColumn => $column) : ?>
            <?= $this->render('_column', [
                'model' => $column,
                'prefix' => $prefix . "[Column][$indexColumn]",
                'product' => $product
            ]); ?>
        <?php endforeach; ?>
    </div>
</div>
