<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MultimediaCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="multimedia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Uložiť', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
