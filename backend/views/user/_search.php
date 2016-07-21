<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'class' => 'disable-are-you-sure'
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'pass') ?>

    <?php // echo $form->field($model, 'datum_vytvorenia') ?>

    <?php // echo $form->field($model, 'active') ?>

    <?php // echo $form->field($model, 'allowPortal') ?>

    <?php // echo $form->field($model, 'actualPortal') ?>

    <?php // echo $form->field($model, 'role') ?>

    <?php // echo $form->field($model, 'isLog') ?>

    <?php // echo $form->field($model, 'cookie_hash') ?>

    <?php // echo $form->field($model, 'lastLog') ?>

    <div class="form-group">
        <?= Html::submitButton('Hľadať', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
