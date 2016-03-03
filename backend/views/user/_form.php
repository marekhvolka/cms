<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pass')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'datum_vytvorenia')->textInput() ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <?= $form->field($model, 'allowPortal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'actualPortal')->textInput() ?>

    <?= $form->field($model, 'role')->textInput() ?>

    <?= $form->field($model, 'isLog')->textInput() ?>

    <?= $form->field($model, 'cookie_hash')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastLog')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
