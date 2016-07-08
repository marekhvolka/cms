<?php

use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Redirect */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="redirect-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form',
        'enableAjaxValidation' => true,
    ]); ?>

    <?= $form->field($model, 'source_url')->textInput() ?>

    <?= $form->field($model, 'target_url')->textInput() ?>

    <?= $form->field($model, 'redirect_type')->widget(Select2::classname(), [
        'data' => [301 => "301", 302 => "302"],
        'language' => 'en',
        'options' => ['placeholder' => 'Výber typu presmerovania ...'],
        'pluginOptions' => [
            'allowClear' => false
        ],
    ]); ?>

    <?= $form->field($model, 'active')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

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

</div>
