<?php

use yii\helpers\Html;
use backend\components\BlockModal\BlockModalWidget;

/* @var $model \backend\models\Block */
/* @var $indexSection int */
/* @var $indexRow int */
/* @var $indexColumn int */
/* @var $indexBlock int */

if (!isset($indexBlock))
    $indexBlock = rand(100, 1000000);

?>

<div class="btn-group layout-block block-<?= $model->id ?>"
     data-content="" role="group">
         <?= Html::hiddenInput("Section[$indexSection][Row][$indexRow][Column][$indexColumn][Block][$indexBlock][existing]", $model->isNewRecord ? 'false' : 'true', ['class' => 'existing']); ?>
         <?= Html::hiddenInput("Section[$indexSection][Row][$indexRow][Column][$indexColumn][Block][$indexBlock][id]", $model->id, ['class' => 'id']); ?>
         <?= Html::hiddenInput("Section[$indexSection][Row][$indexRow][Column][$indexColumn][Block][$indexBlock][column_id]", $model->column_id, ['class' => 'column_id']); ?>
         <?= Html::hiddenInput("Section[$indexSection][Row][$indexRow][Column][$indexColumn][Block][$indexBlock][type]", $model->type, ['class' => 'type']); ?>
         <?= Html::hiddenInput("Section[$indexSection][Row][$indexRow][Column][$indexColumn][Block][$indexBlock][order]", $model->order, ['class' => 'order']); ?>
    <button type="button" class="btn btn-default btn-sm" title="">
        <span class="glyphicon glyphicon-globe"></span>
    </button>

    <button type="button" class="btn btn-default btn-sm text-content-btn btn-block-modal" 
            data-id="<?= $model->id ?>"
            data-target="#modal-<?= $model->id ?>"
            data-toggle="modal">
                <?php echo $model->name; ?>
    </button>

    <?php if (($model->type == 'snippet') && isset($model->snippetCode)) : ?>
        <?=
        Html::a(
                '<span class="glyphicon glyphicon-link"></span>', $model->snippetCode->url, [
            'class' => 'btn btn-info btn-sm',
            'title' => 'Upraviť snippet',
            'target' => '_blank'
                ]
        )
        ?>
    <?php endif; ?>

    <button type="button" class="btn btn-danger btn-sm btn-remove-block" title="Zmazať element">
        <span class="glyphicon glyphicon-remove"></span>
    </button>
</div>

<?= BlockModalWidget::widget([
    'block' => $model,
    'productType' => null,
    ])?>