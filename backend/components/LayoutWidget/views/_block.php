<?php

use yii\helpers\BaseHtml;

/* @var $block \backend\models\Block */

$postIndex = rand(0, 10000000); // Index for correctly indexing Post request variable.
?>

<div class="btn-group layout-block block-<?= $block->id ?>"
     data-content="" role="group">
         <?= BaseHtml::hiddenInput("Block[$postIndex][existing]", $block->isNewRecord ? 'false' : 'true', ['class' => 'existing']); ?>
         <?= BaseHtml::hiddenInput("Block[$postIndex][id]", $block->id ? : $postIndex, ['class' => 'id']); ?>
         <?= BaseHtml::hiddenInput("Block[$postIndex][column_id]", $block->column_id, ['class' => 'column_id']); ?>
         <?= BaseHtml::hiddenInput("Block[$postIndex][type]", $block->type, ['class' => 'type']); ?>
         <?= BaseHtml::hiddenInput("Block[$postIndex][order]", $block->order, ['class' => 'order']); ?>
    <button type="button" class="btn btn-default btn-sm" title="">
        <span class="glyphicon glyphicon-globe"></span>
    </button>

    <button type="button" class="btn btn-default btn-sm text-content-btn btn-block-modal" data-id="<?= $block->id ?>"
            data-target="#blockModal">
                <?php echo $block->name; ?>
    </button>

    <?php if (($block->type == 'snippet') && isset($block->snippetCode)) : ?>
        <?=
        BaseHtml::a(
                '<span class="glyphicon glyphicon-link"></span>', $block->snippetCode->url, [
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
