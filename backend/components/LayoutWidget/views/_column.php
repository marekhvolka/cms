<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 21.06.16
 * Time: 19:54
 */
use backend\models\Portal;
use yii\helpers\BaseHtml;

/* @var $model \backend\models\Column */
/* @var $prefix string */
/* @var $page \backend\models\Page */
/* @var $portal Portal */

?>

<div class="<?= $model->width ? "col-md-$model->width" : ""; ?> panel panel-default column" data-options="{}">
    <?= BaseHtml::hiddenInput($prefix . "[existing]", !$model->isNewRecord, ['class' => 'existing']); ?>
    <?= BaseHtml::hiddenInput($prefix . "[row_id]", $model->row_id, ['class' => 'row_id']); ?>
    <?= BaseHtml::hiddenInput($prefix . "[width]", $model->width, ['class' => 'width']); ?>

    <div class="panel-heading">
        <h4>
            <span class="row-drag-by"><?php echo $model->order; ?>. stĺpec</span>

            <div class="btn-group section-buttons pull-right">
                <div class="inline-button">
                    <button class="btn btn-primary options-btn btn-xs" data-toggle="modal" data-target="#modal-options">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="dropdown dropdown-column-content inline-button add-block">
                    <button type="button" class="btn btn-success dropdown-toggle add-block-btn btn-xs"
                            title="Vložiť nový blok" data-toggle="dropdown" data-prefix="<?= $prefix ?>"
                            data-page-id="<?= $page ? $page->id : '' ?>" data-portal-id="<?= $portal ? $portal->id : '' ?>">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="column-option" data-type="text">Text</a></li>
                        <li><a class="column-option" data-type="html">HTML</a></li>
                        <li><a class="column-option" data-type="snippet">Snippet</a></li>
                        <?php if ($page && $page->product) : ?>
                            <li><a class="column-option" data-type="product_snippet">Produktový snippet</a></li>
                        <?php endif; ?>
                        <li><a class="column-option" data-type="portal_snippet">Portálový snippet</a></li>
                    </ul>
                </div>
                <div class="inline-button">
                    <button type="button" class="btn btn-danger btn-xs btn-remove-row" title="Zmazať">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </h4>
    </div>
    <div class="panel-body children-list blocks">
        <?php foreach ($model->blocks as $indexBlock => $block) : ?>
            <?= $this->render('_block', [
                'model' => $block,
                'prefix' => $prefix . "[Block][$indexBlock]",
                'page' => $page,
                'portal' => $portal
            ]); ?>
        <?php endforeach; ?>
    </div>
</div>
