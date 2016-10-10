<?php

use backend\components\BlockModal\BlockModalWidget;
use backend\models\Portal;
use yii\helpers\Html;

/* @var $model \backend\models\Block */
/* @var $prefix string */
/* @var $layoutOwner \backend\models\LayoutOwner */
/* @var $portal Portal */

if (!isset($renderModal)) {
    $renderModal = false;
}
?>

<div class="btn-group layout-block block" data-content="" role="group" id="block-<?= $model->id ?>"
     data-prefix="<?= $prefix ?>">
    <?= Html::hiddenInput($prefix . "[id]", $model->id, ['class' => 'model_id']); ?>
    <?= Html::hiddenInput($prefix . "[type]", $model->type, ['class' => 'type']); ?>
    <?= Html::hiddenInput($prefix . "[snippet_code_id]", $model->snippet_code_id); ?>
    <?= Html::hiddenInput($prefix . "[removed]", $model->removed, ['class' => 'removed']); ?>
    <button type="button" class="btn btn-default btn-sm" title="">
        <span class="glyphicon glyphicon-globe"></span>
    </button>

    <?php $buttonClass = 'btn-default';
        $buttonIcon = '';
    if ($model->type == 'portal_snippet') {
        $buttonClass = 'btn-primary';
        $buttonIcon = '<i class="fa fa-home"></i>';
    } else if ($model->type == 'product_snippet') {
        $buttonClass = 'btn-primary';
        $buttonIcon = '<i class="fa fa-shopping-cart"></i>';
    }
    ?>

    <button type="button" class="btn <?= $buttonClass ?> btn-sm text-content-btn btn-block-modal block-drag-by"
            data-id="<?= $model->id ?>" data-prefix="<?= $prefix ?>"
            data-layout-owner-id="<?= $layoutOwner ? $layoutOwner->id : '' ?>"
            data-layout-owner-type="<?= $layoutOwner ? $layoutOwner->getType() : '' ?>"
            data-portal-id="<?= $portal ? $portal->id : '' ?>"
            data-target="#modal-<?= $model->id ?>" data-block-type="<?= $model->type ?>">
        <?php echo $buttonIcon . ' ' . $model->name; ?>
    </button>

    <?php if (($model->type == 'snippet') && $model->snippetCode) : ?>
        <?=
        Html::a(
            '<span class="glyphicon glyphicon-link"></span>', $model->snippetCode->url, [
                'class' => 'btn btn-info btn-sm',
                'title' => 'Upraviť snippet',
                'target' => '_blank',
                'data' => [
                    'pjax' => false
                ]
            ]
        ) ?>
    <?php endif; ?>

    <?php if ((($model->type == 'portal_snippet') || ($model->type == 'product_snippet')) && $model->parent && $model->parent->snippetCode) : ?>
        <?=
        Html::a(
            '<span class="glyphicon glyphicon-link"></span>', $model->parent->snippetCode->url, [
                'class' => 'btn btn-info btn-sm',
                'title' => 'Upraviť snippet',
                'target' => '_blank',
                'data' => [
                    'pjax' => false
                ]
            ]
        ) ?>
    <?php endif; ?>

    <button type="button" class="btn btn-danger btn-sm btn-remove-block" title="Zmazať element">
        <span class="glyphicon glyphicon-remove"></span>
    </button>

    <div class="modal-container">
        <?= BlockModalWidget::widget([
            'block' => $model,
            'layoutOwner' => $layoutOwner,
            'portal' => $portal,
            'prefix' => $prefix
        ]) ?>
    </div>
    <div class="clearfix"></div>
</div>