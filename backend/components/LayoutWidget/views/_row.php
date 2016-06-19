<?php
use yii\helpers\BaseHtml;

/* @var $row backend\models\Row */

$postIndex = rand(0, 10000000); // Index for correctly indexing Post request variable.
?>

<!--ROW TO ADD-->
<div class="row layout-row">
    <?php $row->id = $row->id ? : $postIndex ?>
    <?= BaseHtml::hiddenInput("Row[$postIndex][existing]", $row->isNewRecord ? 'false' : 'true', ['class' => 'existing']); ?>
    <?= BaseHtml::hiddenInput("Row[$postIndex][id]", $row->id, ['class' => 'id']); ?>
    <?= BaseHtml::hiddenInput("Row[$postIndex][section_id]", $row->section_id, ['class' => 'section_id']); ?>
    <?= BaseHtml::hiddenInput("Row[$postIndex][order]", $row->order, ['class' => 'order']); ?>
    <?php $columns = $row->columns ? : $columns ?>
    <?php foreach ($columns as $column) : ?>
        <!--COLUMN TO ADD-->
        <div class="<?= $column->width ? "col-md-$column->width" : ""; ?> panel panel-default column" 
             data-options="{}">
            <?php $postIndex = rand(0, 10000000); // Index for correctly indexing Post request variable. ?>
            <?= BaseHtml::hiddenInput("Column[$postIndex][existing]", $column->isNewRecord ? 'false' : 'true', ['class' => 'existing']); ?>
            <?= BaseHtml::hiddenInput("Column[$postIndex][id]", $column->id ? : $postIndex, ['class' => 'id']); ?>
            <?= BaseHtml::hiddenInput("Column[$postIndex][row_id]", $row->id, ['class' => 'row_id']); ?>
            <?= BaseHtml::hiddenInput("Column[$postIndex][width]", $column->width, ['class' => 'width']); ?>
            <?= BaseHtml::hiddenInput("Column[$postIndex][order]", $column->order, ['class' => 'order']); ?>
            <div class="btn-group section-buttons">
                <div class="section-button">
                    <button class="btn btn-primary options-btn btn-xs" data-toggle="modal" data-target="#modal-options">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="dropdown dropdown-column-content section-button">
                    <button type="button" class="btn btn-success dropdown-toggle add-row-btn btn-xs"
                            title="Vložiť nový blok" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="column-option text-option" data-toggle="modal" data-target="#modal-text">Text</a></li>
                        <li><a class="column-option html-option">HTML</a></li>
                        <li><a class="column-option smart-snippet-option" data-target="#modal-432523">Snippet</a></li>
                        <li><a class="column-option product-snippet-option">Produktový snippet</a></li>
                        <li><a class="column-option portal-snippet-option">Portálový snippet</a></li>
                    </ul>
                </div>
                <div class="section-button">
                    <button type="button" class="btn btn-danger btn-xs btn-remove-row" title="Zmazať" >
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                </div>
            </div>

            <div class="panel-heading"><?php echo $column->order; ?>. stĺpec</div>
            <div class="panel-body">
                <ul class="children-list">
                    <?php foreach ($column->blocks as $block) : ?>
                        <li>
                            <?= $this->render('_block', ['block' => $block]); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

    <?php endforeach; ?>
</div>
