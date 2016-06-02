<?php

use yii\helpers\BaseHtml;

/* @var $block \backend\models\Block */

$postIndex = rand(0, 10000000); // Index for correctly indexing Post request variable.
?>

<?= BaseHtml::hiddenInput("Block[$postIndex][existing]", $block->isNewRecord ? 'false' : 'true', ['class' => 'existing']); ?>
<?= BaseHtml::hiddenInput("Block[$postIndex][id]", $block->id, ['class' => 'id']); ?>
<?= BaseHtml::hiddenInput("Block[$postIndex][section_id]", $block->column_id, ['class' => 'section_id']); ?>

<div class="btn-group block_element <?= $block->id ?>"
     data-content="" role="group">
    <button type="button" class="btn btn-default btn-sm" title="Nastavenie publikovania">
        <span class="glyphicon glyphicon-globe"></span>
    </button>

    <button type="button" class="btn btn-default btn-sm text-content-btn">
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

    <button type="button" class="btn btn-danger btn-sm" title="Zmazať element">
        <span class="glyphicon glyphicon-remove"></span>
    </button>
</div>
