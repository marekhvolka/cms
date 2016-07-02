<?php
use yii\helpers\BaseHtml;

/* @var $model backend\models\Row */
/* @var $prefix string */
/* @var $productType \backend\models\ProductType */

?>

<div class="row layout-row" data-prefix="<?= $prefix ?>" data-product-type-id="<?= $productType ? $productType->id : '' ?>">
    <?= BaseHtml::hiddenInput($prefix . "[existing]", !$model->isNewRecord, ['class' => 'existing']); ?>
    <?= BaseHtml::hiddenInput($prefix . "[section_id]", $model->section_id, ['class' => 'section_id']); ?>
    <div class="children-list">
        <?php foreach ($model->columns as $indexColumn => $column) : ?>
            <?= $this->render('_column', [
                'model' => $column,
                'prefix' => $prefix . "[Column][$indexColumn]",
                'productType' => $productType
            ]); ?>
        <?php endforeach; ?>
    </div>
</div>
