<?php
use yii\helpers\BaseHtml;

/* @var $section backend\models\Section */

$postIndex = rand(0, 10000000); // Index for correctly indexing Post request variable.
?>
<!--SECTION TO ADD-->
<div class="panel panel-default section" data-options="{}">
    <?= BaseHtml::hiddenInput("Section[$postIndex][existing]", $section->isNewRecord ? 'false' : 'true', ['class' => 'existing']); ?>
    <?= BaseHtml::hiddenInput("Section[$postIndex][id]", $section->id ? : $postIndex, ['class' => 'id']); ?>
    <?= BaseHtml::hiddenInput("Section[$postIndex][type]", $section->type, ['class' => 'type']); ?>
    <div class="btn-group section-buttons">
        <div class="section-button">
            <button class="btn btn-primary options-btn btn-xs" data-toggle="modal" data-target="#modal-options">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </button>
        </div>
        <div class="dropdown dropdown-blocks section-button">
            <button type="button" class="btn btn-success dropdown-toggle add-row-btn btn-xs"
                    title="Vložiť nový blok" data-toggle="dropdown">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
            <ul class="dropdown-menu">
                <li><div></div><a class="add-row" data-row-type-width="1">Fullwidth blok</a></li>
                <li><a class="add-row" data-row-type-width="2">2 stĺpcový blok</a></li>
                <li><a class="add-row" data-row-type-width="3">3 stĺpcový blok</a></li>
                <li><a class="add-row" data-row-type-width="4">4 stĺpcový blok</a></li>
                <li><a class="add-row" data-row-type-width="2/1">2/1 blok</a></li>
                <li><a class="add-row" data-row-type-width="1/2">1/2 blok</a></li>
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
            <ul class="section-rows">
                <?php foreach ($section->rows as $row) : ?>
                    <li>
                        <?= $this->render('_row', ['row' => $row]); ?>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>
