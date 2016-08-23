<?php
/* @var $this yii\web\View */
use backend\components\LayoutWidget\AssetBundle;
use backend\models\Area;
use backend\models\Portal;
use yii\helpers\Html;

/* @var $form yii\widgets\ActiveForm */
/* @var $area Area */

/* @var $allowAddingSection bool */

/* @var $prefix string */
/* @var $page \backend\models\Page */
/* @var $portal Portal */
/* @var $type string */

AssetBundle::register($this);

?>

<div class="layouts area" data-prefix="<?= $prefix ?>">
    <?= Html::hiddenInput($prefix . "[type]", $area->type); ?>
    <?= Html::hiddenInput($prefix . "[id]", $area->id, ['class' => 'model_id']); ?>
    <?= Html::hiddenInput($prefix . "[removed]", $area->removed, ['class' => 'removed']); ?>
    <div class="children-list sections">
        <?php foreach ($area->sections as $indexSection => $section) : ?>
            <?= $this->render('_section', [
                'model' => $section,
                'prefix' => $prefix . "[Section][$indexSection]",
                'page' => $page,
                'portal' => $portal
            ]); ?>
        <?php endforeach; ?>
    </div>
    <div class="col-sm-10 col-sm-offset-2">
        <?php if ($allowAddingSection) : ?>
        <button type="button" class="btn btn-success btn-sm add-section-btn" data-prefix="<?= $area->type ?>[Section]"
                data-page-id="<?= $page ? $page->id : '' ?>" data-portal-id="<?= $portal ? $portal->id : '' ?>">
            <span class="glyphicon glyphicon-plus"></span> Pridať sekciu
        </button>
        <?php endif; ?>
    </div>
</div> 

<?php

$js = <<<JS

var controllerUrl = '$controllerUrl';
        
JS;

$this->registerJs($js, \yii\web\View::POS_BEGIN);
?>
