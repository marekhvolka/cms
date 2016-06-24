<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $sections \backend\models\Section */

/* @var $allowAddingSection bool */

/* @var $prefix string */
?>

<div class="layouts">
    <?php
    $idHash = Yii::$app->security->generateRandomString();  // ID as hash for using more layoutWidget in one view.
    ?>
    <div class="children-list" id="<?= $idHash ?>">
        <?php foreach ($sections as $indexSection => $section) : ?>
            <?= $this->render('_section', [
                'model' => $section,
                'prefix' => $prefix . "[$indexSection]"
            ]); ?>
        <?php endforeach; ?>
    </div>
    <div class="col-sm-10 col-sm-offset-2">
        <?php if ($allowAddingSection) : ?>
        <button type="button" class="btn btn-success btn-sm btn-add-section" data-sections-id="<?= $idHash ?>"
                data-prefix="<?= $prefix ?>">
            <span class="glyphicon glyphicon-plus"></span> Pridať sekciu
        </button>
        <?php endif; ?>
    </div>
</div> 

<?php

$js = <<<JS

var controllerUrl = '$controllerUrl';
var layoutType = '$type';
var formId = '$formId';
        
JS;

$this->registerJs($js, \yii\web\View::POS_BEGIN);
?>
