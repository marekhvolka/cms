<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 21.06.16
 * Time: 19:54
 */
use yii\helpers\BaseHtml;

/* @var $model \backend\models\Column */
/* @var $itemId int */
/* @var $indexSection int */
/* @var $indexRow int */
/* @var $indexColumn int */

if (!isset($indexColumn))
    $indexColumn = rand(100, 1000000);

?>

<div class="<?= $model->width ? "col-md-$model->width" : ""; ?> panel panel-default column" data-options="{}">
    <?= BaseHtml::hiddenInput("Section[$indexSection][Row][$indexRow][Column][$indexColumn][existing]", $model->isNewRecord ? 'false' : 'true', ['class' => 'existing']); ?>
    <?= BaseHtml::hiddenInput("Section[$indexSection][Row][$indexRow][Column][$indexColumn][id]", $model->id, ['class' => 'id']); ?>
    <?= BaseHtml::hiddenInput("Section[$indexSection][Row][$indexRow][Column][$indexColumn][row_id]", $model->row_id, ['class' => 'row_id']); ?>
    <?= BaseHtml::hiddenInput("Section[$indexSection][Row][$indexRow][Column][$indexColumn][width]", $model->width, ['class' => 'width']); ?>
    <?= BaseHtml::hiddenInput("Section[$indexSection][Row][$indexRow][Column][$indexColumn][order]", $model->order, ['class' => 'order']); ?>
    <div class="btn-group section-buttons">
        <div class="section-button">
            <button class="btn btn-primary options-btn btn-xs" data-toggle="modal" data-target="#modal-options">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </button>
        </div>
        <div class="dropdown dropdown-column-content section-button">
            <button type="button" class="btn btn-success dropdown-toggle add-row-btn btn-xs"
                    title="Vložiť nový blok" data-toggle="dropdown" data-index-section="<?= $indexSection ?>"
                    data-index-row="<?= $indexRow ?>" data-index-column="<?= $indexColumn ?>" >
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

    <div class="panel-heading"><?php echo $model->order; ?>. stĺpec</div>
    <div class="panel-body">
        <ul class="children-list">
            <?php foreach ($model->blocks as $indexBlock => $block) : ?>
                <li>
                    <?= $this->render('_block', [
                        'model' => $block,
                        'indexSection' => $indexSection,
                        'indexRow' => $indexRow,
                        'indexColumn' => $indexColumn,
                        'indexBlock' => $indexBlock
                    ]); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
