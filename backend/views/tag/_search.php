<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TagSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tag-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'nazov_system') ?>

    <?= $form->field($model, 'identifikator') ?>

    <?= $form->field($model, 'active') ?>

    <?php // echo $form->field($model, 'product_type') ?>

    <?php // echo $form->field($model, 'last_edit') ?>

    <?php // echo $form->field($model, 'last_edit_user') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
