<?php

use backend\models\TrackingCode;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;


/* @var $this yii\web\View */
/* @var $model backend\models\TrackingCode */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tracking-code-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'place_id')->dropDownList(
        ArrayHelper::map(TrackingCode::getPlaces(), 'id', 'name')
    ) ?>

    <?= $form->field($model, 'active')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <div class="navbar-fixed-bottom">
        <div class="col-sm-10 col-sm-offset-2">
            <div class="form-group">
                <?= Html::submitButton('Uložiť', [
                    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                    'id' => 'submit-btn'
                ]) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
