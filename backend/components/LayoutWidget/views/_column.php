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
/* @var $prefix string */
/* @var $productType \backend\models\ProductType */

?>

<div class="<?= $model->width ? "col-md-$model->width" : ""; ?> panel panel-default column" data-options="{}">
    <?= BaseHtml::hiddenInput($prefix . "[existing]", !$model->isNewRecord, ['class' => 'existing']); ?>
    <?= BaseHtml::hiddenInput($prefix . "[row_id]", $model->row_id, ['class' => 'row_id']); ?>
    <?= BaseHtml::hiddenInput($prefix . "[width]", $model->width, ['class' => 'width']); ?>
    <div class="btn-group section-buttons">
        <div class="inline-button">
            <button class="btn btn-primary options-btn btn-xs" data-toggle="modal" data-target="#modal-options">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </button>
        </div>
        <div class="dropdown dropdown-column-content inline-button add-block">
            <button type="button" class="btn btn-success dropdown-toggle add-block-btn btn-xs"
                    title="Vložiť nový blok" data-toggle="dropdown" data-prefix="<?= $prefix ?>"
                    data-product-type-id="<?= $productType->id ?>">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="column-option" data-type="text">Text</a></li>
                <li><a class="column-option" data-type="html">HTML</a></li>
                <li><a class="column-option" data-type="snippet">Snippet</a></li>
                <li><a class="column-option" data-type="product_snippet">Produktový snippet</a></li>
                <li><a class="column-option" data-type="portal_snippet">Portálový snippet</a></li>
            </ul>
        </div>
        <div class="inline-button">
            <button type="button" class="btn btn-danger btn-xs btn-remove-row" title="Zmazať">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    <div class="panel-heading"><?php echo $model->order; ?>. stĺpec</div>
    <div class="panel-body children-list">
        <?php foreach ($model->blocks as $indexBlock => $block) : ?>
            <?= $this->render('_block', [
                'model' => $block,
                'prefix' => $prefix . "[Block][$indexBlock]",
                'productType' => $productType
            ]); ?>
        <?php endforeach; ?>
    </div>
</div>
