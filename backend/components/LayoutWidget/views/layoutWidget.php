<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $sections \backend\models\Section */

/* @var $allowAddingSection bool */

/* @var $prefix string */
/* @var $product \backend\models\Product */
/* @var $type string */

?>

<div class="layouts">
    <div class="children-list">
        <?php foreach ($sections as $indexSection => $section) : ?>
            <?= $this->render('_section', [
                'model' => $section,
                'prefix' => $prefix . "[$indexSection]",
                'product' => $product
            ]); ?>
        <?php endforeach; ?>
    </div>
    <div class="col-sm-10 col-sm-offset-2">
        <?php if ($allowAddingSection) : ?>
        <button type="button" class="btn btn-success btn-sm btn-add-section"
                data-prefix="<?= $prefix ?>" data-type="<?= $type ?>" data-product-id="<?= $product ? $product->id : '' ?>">
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
