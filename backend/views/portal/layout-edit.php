<?php

use backend\components\LayoutWidget\LayoutWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model \backend\models\Portal */
/* @var $form yii\widgets\ActiveForm */
/* @var $type string layout type - either header or footer */
?>
 
<?php $form = ActiveForm::begin([
        'id' => 'form-layout', 
        'enableAjaxValidation' => true,
        ]); ?>

<?= LayoutWidget::widget([
        'area' => $model->{$type},
        'controllerUrl' => Url::to(['/portal']),
        'formId' => 'form-layout',
        'product' => null
    ]
)?>

<div class="navbar-fixed-bottom">
    <div class="col-sm-10 col-sm-offset-2">
        <div class="form-group">
            <?= Html::submitButton('Uložiť', [
                'class' => 'btn btn-primary',
                'id' => 'submit-btn'
            ]) ?>

            <?= Html::submitButton('Uložiť a pokračovať', [
                'class' => 'btn btn-info',
                'id' => 'submit-btn',
                'name' => 'continue'
            ]) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

