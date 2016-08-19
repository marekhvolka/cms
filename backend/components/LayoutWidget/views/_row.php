<?php
use backend\models\Portal;
use yii\helpers\BaseHtml;

/* @var $model backend\models\Row */
/* @var $prefix string */
/* @var $page \backend\models\Page */
/* @var $portal Portal */

?>

<div class="row layout-row" data-prefix="<?= $prefix ?>" data-page-id="<?= $page ? $page->id : '' ?>"
     data-portal-id="<?= $portal ? $portal->id : '' ?>">
    <?= BaseHtml::hiddenInput($prefix . "[section_id]", $model->section_id, ['class' => 'section_id']); ?>
    <?= BaseHtml::hiddenInput($prefix . "[id]", $model->id); ?>
    <div class="children-list">
        <?php foreach ($model->columns as $indexColumn => $column) : ?>
            <?= $this->render('_column', [
                'model' => $column,
                'prefix' => $prefix . "[Column][$indexColumn]",
                'page' => $page,
                'portal' => $portal
            ]); ?>
        <?php endforeach; ?>
    </div>
</div>
