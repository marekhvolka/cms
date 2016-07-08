<?php

use backend\components\BlockModal\BlockModalWidget;
use yii\helpers\Html;

/* @var $model \backend\models\Block */
/* @var $prefix string */
/* @var $product \backend\models\Product */

if (!isset($renderModal)) {
    $renderModal = false;
}
?>

<div class="btn-group layout-block block" data-content="" role="group" id="block-<?= $model->id ?>">
    <?= Html::hiddenInput($prefix . "[existing]", !$model->isNewRecord, ['class' => 'existing']); ?>
    <?= Html::hiddenInput($prefix . "[column_id]", $model->column_id, ['class' => 'column_id']); ?>
    <?= Html::hiddenInput($prefix . "[type]", $model->type, ['class' => 'type']); ?>
    <button type="button" class="btn btn-default btn-sm" title="">
        <span class="glyphicon glyphicon-globe"></span>
    </button>

    <button type="button" class="btn btn-default btn-sm text-content-btn btn-block-modal"
            data-id="<?= $model->id ?>" data-prefix="<?= $prefix ?>" data-product-id="<?= $product ? $product->id : '' ?>"
            data-target="#modal-<?= $model->id ?>" data-block-type="<?= $model->type ?>">
        <?php echo $model->name; ?>
    </button>

    <?php if (($model->type == 'snippet') && $model->snippetCode) : ?>
        <?=
        Html::a(
            '<span class="glyphicon glyphicon-link"></span>', $model->snippetCode->url, [
                'class' => 'btn btn-info btn-sm',
                'title' => 'Upraviť snippet',
                'target' => '_blank'
            ]
        ) ?>
    <?php endif; ?>

    <?php if ((($model->type == 'portal_snippet') || ($model->type == 'product_snippet')) && $model->parent && $model->parent->snippetCode) : ?>
        <?=
        Html::a(
            '<span class="glyphicon glyphicon-link"></span>', $model->parent->snippetCode->url, [
                'class' => 'btn btn-info btn-sm',
                'title' => 'Upraviť snippet',
                'target' => '_blank'
            ]
        ) ?>
    <?php endif; ?>

    <button type="button" class="btn btn-danger btn-sm btn-remove-block" title="Zmazať element">
        <span class="glyphicon glyphicon-remove"></span>
    </button>

    <div class="modal-container">
        <?php if (Yii::$app->request->get('duplicate') || $renderModal) {
            echo BlockModalWidget::widget([
                'block' => $model,
                'product' => $product,
                'prefix' => $prefix
            ]);
        } ?>
    </div>
    <div class="clearfix"></div>
</div>