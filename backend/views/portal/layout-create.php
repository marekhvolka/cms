<?php

use backend\components\LayoutWidget\LayoutWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $sections backend\models\Section */
/* @var $type string layout type - either header or footer */
?>
 
<?php $form = ActiveForm::begin([
        'id' => 'form-layout', 
        'enableAjaxValidation' => true,
        ]); ?>

<?= LayoutWidget::widget([
        'sections' => $sections,
        'controllerUrl' => Url::to(['/portal']),
        'formId' => 'form-layout',
    ]
)?>

<div class="navbar-fixed-bottom">
    <div class="col-sm-10 col-sm-offset-2">
        <div class="form-group">
            <?= Html::submitButton('Uložiť', [
                'class' => 'btn btn-primary',
                'id' => 'submit-btn'
            ]) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

