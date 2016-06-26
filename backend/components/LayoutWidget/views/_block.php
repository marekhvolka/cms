<?php

use yii\helpers\Html;
use backend\components\BlockModal\BlockModalWidget;

/* @var $model \backend\models\Block */
/* @var $prefix string */

?>

<div class="btn-group layout-block block-<?= $model->id ?>"
     data-content="" role="group">
         <?= Html::hiddenInput($prefix . "[existing]", !$model->isNewRecord, ['class' => 'existing']); ?>
         <?= Html::hiddenInput($prefix . "[id]", $model->id, ['class' => 'id']); ?>
         <?= Html::hiddenInput($prefix . "[column_id]", $model->column_id, ['class' => 'column_id']); ?>
         <?= Html::hiddenInput($prefix . "[type]", $model->type, ['class' => 'type']); ?>
         <?= Html::hiddenInput($prefix . "[order]", $model->order, ['class' => 'order']); ?>
    <button type="button" class="btn btn-default btn-sm" title="">
        <span class="glyphicon glyphicon-globe"></span>
    </button>

    <button type="button" class="btn btn-default btn-sm text-content-btn btn-block-modal" 
            data-id="<?= $model->id ?>" data-prefix="<?= $prefix ?>"
            data-target="#modal-<?= $model->id ?>"  >
                <?php echo $model->name; ?>
    </button>

    <?php if (($model->type == 'snippet')) : ?>
        <?=
        Html::a(
                '<span class="glyphicon glyphicon-link"></span>', $model->snippetCode->url, [
            'class' => 'btn btn-info btn-sm',
            'title' => 'Upraviť snippet',
            'target' => '_blank'
                ]
        ) ?>
    <?php endif; ?>

    <?php if (($model->type == 'portal_snippet') || ($model->type == 'product_snippet')) : ?>
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

    </div>
</div>