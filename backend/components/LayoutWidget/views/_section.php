<?php
use yii\helpers\BaseHtml;

/* @var $model backend\models\Section */
/* @var $indexSection int */

if (!isset($indexSection))
    $indexSection = rand(100, 1000000);

?>
<!--SECTION TO ADD-->
<div class="panel panel-default section" data-options="{}">
    <?= BaseHtml::hiddenInput("Section[$indexSection][existing]", $model->isNewRecord ? 'false' : 'true', ['class' => 'existing']); ?>
    <?= BaseHtml::hiddenInput("Section[$indexSection][id]", $model->id, ['class' => 'id']); ?>
    <?= BaseHtml::hiddenInput("Section[$indexSection][type]", $model->type, ['class' => 'type']); ?>
    <?= BaseHtml::hiddenInput("Section[$indexSection][portal_id]", $model->portal_id, ['class' => 'portal_id']); ?>
    <?= BaseHtml::hiddenInput("Section[$indexSection][page_id]", $model->page_id, ['class' => 'page_id']); ?>
    <div class="btn-group section-buttons">
        <div class="section-button">
            <button class="btn btn-primary options-btn btn-xs" data-toggle="modal" data-target="#modal-options">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </button>
        </div>
        <div class="dropdown dropdown-blocks section-button">
            <button type="button" class="btn btn-success dropdown-toggle add-row-btn btn-xs"
                    title="Vložiť nový riadok" data-toggle="dropdown" data-index-section="<?= $indexSection ?>">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
            <ul class="dropdown-menu">
                <li><div></div><a class="add-row" data-row-type-width="1">Fullwidth riadok</a></li>
                <li><a class="add-row" data-row-type-width="2">2 stĺpcový riadok</a></li>
                <li><a class="add-row" data-row-type-width="3">3 stĺpcový riadok</a></li>
                <li><a class="add-row" data-row-type-width="4">4 stĺpcový riadok</a></li>
                <li><a class="add-row" data-row-type-width="2/1">2/1 riadok</a></li>
                <li><a class="add-row" data-row-type-width="1/2">1/2 riadok</a></li>
            </ul>
        </div>
        <div class="section-button">
            <button type="button" class="btn btn-danger btn-xs btn-remove-section" title="Zmazať" >
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    <div class="panel-heading"><h3 class="panel-title">Sekcia</h3></div>
    <div class="panel-body">
        <div class="col-sm-12">
            <ul class="children-list">
                <?php foreach ($model->rows as $indexRow => $row) : ?>
                    <li>
                        <?= $this->render('_row', [
                            'model' => $row,
                            'indexSection' => $indexSection,
                            'indexRow' => $indexRow
                        ]); ?>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>
