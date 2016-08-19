<?php
use backend\models\Portal;
use yii\bootstrap\Html;
use yii\helpers\BaseHtml;

/* @var $model backend\models\Section */
/* @var $prefix string */
/* @var $page \backend\models\Page */
/* @var $portal Portal */

?>
<!--SECTION TO ADD-->
<div class="panel panel-default section" data-options="{}">
    <?= BaseHtml::hiddenInput($prefix . "[area_id]", $model->area_id); ?>
    <?= BaseHtml::hiddenInput($prefix . "[id]", $model->id); ?>
    <div class="panel-heading">
        <h3 class="panel-title">
            <span>
                <i class="glyphicon glyphicon-chevron-up collapse-btn"></i>
            </span>
            <span class="section-drag-by">Sekcia</span>
            <?= empty($model->css_id) ? '' : 'ID: [' . $model->css_id . ']' ?>
            <?= empty($model->css_class) ? '' : 'CLASS: [' . $model->css_class . ']' ?>

            <div class="btn-group section-buttons pull-right">
                <div class="inline-button">
                    <button class="btn btn-primary options-btn btn-xs open-section-options">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="dropdown dropdown-cols inline-button">
                    <button type="button" class="btn btn-success dropdown-toggle add-row-btn btn-xs"
                            data-prefix="<?= $prefix ?>"
                            data-page-id="<?= $page ? $page->id : '' ?>"
                            data-portal-id="<?= $portal ? $portal->id : '' ?>"
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
            <?= $this->render('_section-column-options', ['model' => $model, 'prefix' => $prefix]) ?>
        </h3>
    </div>
    <div class="panel-body">
        <div class="col-sm-12 children-list rows">
            <?php foreach ($model->rows as $indexRow => $row) : ?>
                <?= $this->render('_row', [
                    'model' => $row,
                    'prefix' => $prefix . "[Row][$indexRow]",
                    'page' => $page,
                    'portal' => $portal
                ]); ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
