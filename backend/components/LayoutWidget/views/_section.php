<?php
use yii\helpers\BaseHtml;

/* @var $model backend\models\Section */
/* @var $prefix string */
/* @var $productType \backend\models\ProductType */

?>
<!--SECTION TO ADD-->
<div class="panel panel-default section" data-options="{}">
    <?= BaseHtml::hiddenInput($prefix . "[existing]", !$model->isNewRecord, ['class' => 'existing']); ?>
    <?= BaseHtml::hiddenInput($prefix . "[type]", $model->type, ['class' => 'type']); ?>
    <div class="btn-group section-buttons">
        <div class="inline-button">
            <button class="btn btn-primary options-btn btn-xs" data-toggle="modal" data-target="#modal-options">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </button>
        </div>
        <div class="dropdown dropdown-cols inline-button">
            <button type="button" class="btn btn-success dropdown-toggle add-row-btn btn-xs"
                    data-prefix="<?= $prefix ?>" data-product-type-id="<?= $productType ? $productType->id : '' ?>"
                    title="Vložiť nový riadok" data-toggle="dropdown">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <div></div>
                    <a class="add-row" data-row-type-width="1">Fullwidth riadok</a></li>
                <li><a class="add-row" data-row-type-width="2">2 stĺpcový riadok</a></li>
                <li><a class="add-row" data-row-type-width="3">3 stĺpcový riadok</a></li>
                <li><a class="add-row" data-row-type-width="4">4 stĺpcový riadok</a></li>
                <li><a class="add-row" data-row-type-width="2/1">2/1 riadok</a></li>
                <li><a class="add-row" data-row-type-width="1/2">1/2 riadok</a></li>
            </ul>
        </div>
        <div class="inline-button">
            <button type="button" class="btn btn-danger btn-xs btn-remove-section" title="Zmazať">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    <div class="panel-heading"><h3 class="panel-title">Sekcia</h3></div>
    <div class="panel-body">
        <div class="col-sm-12 children-list">
            <?php foreach ($model->rows as $indexRow => $row) : ?>
                <?= $this->render('_row', [
                    'model' => $row,
                    'prefix' => $prefix . "[Row][$indexRow]",
                    'productType' => $productType
                ]); ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
