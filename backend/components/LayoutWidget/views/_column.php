<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 21.06.16
 * Time: 19:54
 */
use backend\models\Portal;
use yii\bootstrap\Html;

/* @var $model \backend\models\Column */
/* @var $prefix string */
/* @var $layoutOwner \backend\models\LayoutOwner */
/* @var $portal Portal */

?>

<div class="<?= $model->width ? "col-md-$model->width" : ""; ?> panel panel-default column" data-prefix="<?= $prefix ?>">
    <?= Html::hiddenInput($prefix . "[id]", $model->id, ['class' => 'model_id']); ?>
    <?= Html::hiddenInput($prefix . "[width]", $model->width, ['class' => 'width']); ?>
    <?= Html::hiddenInput($prefix . "[removed]", $model->removed, ['class' => 'removed']); ?>

    <div class="panel-heading">
        <h4>
            <span class="row-drag-by"><?php echo $model->order; ?>. stĺpec</span>
            <?= empty($model->css_id) ? '' : 'ID: [' . $model->css_id . ']' ?>
            <?= empty($model->css_class) ? '' : 'CLASS: [' . $model->css_class . ']' ?>

            <div class="btn-group section-buttons pull-right">
                <div class="inline-button">
                    <button class="btn btn-primary options-btn btn-xs open-column-options">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="dropdown dropdown-column-content inline-button add-block-dropdown">
                    <button type="button" class="btn btn-success dropdown-toggle add-block-btn btn-xs"
                            title="Vložiť nový blok" data-toggle="dropdown" data-prefix="<?= $prefix ?>">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="add-block" data-type="text">Text</a></li>
                        <li><a class="add-block" data-type="html">HTML</a></li>
                        <li><a class="add-block" data-type="snippet">Snippet</a></li>
                        <?php if ($layoutOwner && $layoutOwner->isPage() && $layoutOwner->product) : ?>
                            <li><a class="add-block" data-type="product_snippet">Produktový snippet</a></li>
                        <?php endif; ?>
                        <li><a class="add-block" data-type="portal_snippet">Portálový snippet</a></li>
                    </ul>
                </div>
                <div class="inline-button">
                    <button type="button" class="btn btn-danger btn-xs btn-remove-row" title="Zmazať">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </h4>
        <?= $this->render('_section-column-options', ['model' => $model, 'prefix' => $prefix]) ?>
    </div>
    <div class="panel-body children-list blocks">
        <?php foreach ($model->blocks as $indexBlock => $block) : ?>
            <?= $this->render('_block', [
                'model' => $block,
                'prefix' => $prefix . "[Block][$indexBlock]",
                'layoutOwner' => $layoutOwner,
                'portal' => $portal
            ]); ?>
        <?php endforeach; ?>
    </div>
</div>
