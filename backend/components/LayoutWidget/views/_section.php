<?php
use backend\models\Portal;
use yii\bootstrap\Html;
use yii\helpers\BaseHtml;

/* @var $model backend\models\Section */
/* @var $prefix string */
/* @var $layoutOwner \backend\models\LayoutOwner */
/* @var $portal Portal */
/* @var $allowAddingSection bool */

if (!isset($allowAddingSection)) {
    $allowAddingSection = true;
}

?>
<!--SECTION TO ADD-->
<div class="panel panel-default section" data-options="{}" data-prefix="<?= $prefix ?>">
    <?= Html::hiddenInput($prefix . "[id]", $model->id, ['class' => 'model_id']); ?>
    <?= Html::hiddenInput($prefix . "[removed]", $model->removed, ['class' => 'removed']); ?>
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
                <?php if ($allowAddingSection) : ?>
                <div class="inline-button">
                    <button type="button" class="btn btn-danger btn-xs btn-remove-section" title="Zmazať">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                </div>
                <?php endif; ?>
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
                    'layoutOwner' => $layoutOwner,
                    'portal' => $portal
                ]); ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
