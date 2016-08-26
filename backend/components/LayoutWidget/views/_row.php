<?php
use backend\models\Portal;
use yii\helpers\Html;

/* @var $model backend\models\Row */
/* @var $prefix string */
/* @var $layoutOwner \backend\models\LayoutOwner */
/* @var $portal Portal */

?>

<div class="row layout-row" data-prefix="<?= $prefix ?>" data-portal-id="<?= $portal ? $portal->id : '' ?>"
     data-layout-owner-id="<?= $layoutOwner ? $layoutOwner->id : '' ?>"
     data-layout-owner-type="<?= $layoutOwner ? $layoutOwner->getType() : '' ?>">
    
    <?= Html::hiddenInput($prefix . "[id]", $model->id, ['class' => 'model_id']); ?>
    <?= Html::hiddenInput($prefix . "[removed]", $model->removed, ['class' => 'removed']); ?>
    <div class="children-list">
        <?php foreach ($model->columns as $indexColumn => $column) : ?>
            <?= $this->render('_column', [
                'model' => $column,
                'prefix' => $prefix . "[Column][$indexColumn]",
                'layoutOwner' => $layoutOwner,
                'portal' => $portal
            ]); ?>
        <?php endforeach; ?>
    </div>
</div>
