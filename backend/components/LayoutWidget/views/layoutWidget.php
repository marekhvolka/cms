<?php
/* @var $this yii\web\View */
use backend\models\Area;
use yii\helpers\BaseHtml;

/* @var $form yii\widgets\ActiveForm */
/* @var $area Area */

/* @var $allowAddingSection bool */

/* @var $prefix string */
/* @var $product \backend\models\Product */
/* @var $type string */

?>

<div class="layouts">
    <?= BaseHtml::hiddenInput($prefix . "[type]", $area->type); ?>
    <div class="children-list sections">
        <?php foreach ($area->sections as $indexSection => $section) : ?>
            <?= $this->render('_section', [
                'model' => $section,
                'prefix' => $prefix . "[Section][$indexSection]",
                'product' => $product
            ]); ?>
        <?php endforeach; ?>
    </div>
    <div class="col-sm-10 col-sm-offset-2">
        <?php if ($allowAddingSection) : ?>
        <button type="button" class="btn btn-success btn-sm btn-add-section"
                data-prefix="<?= $area->type ?>[Section]" data-product-id="<?= $product ? $product->id : '' ?>">
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
