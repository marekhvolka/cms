<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductVarSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-var-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'value') ?>

    <?= $form->field($model, 'identifier') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'type_id') ?>

    <?php // echo $form->field($model, 'product_type') ?>

    <?php // echo $form->field($model, 'last_edit') ?>

    <?php // echo $form->field($model, 'last_edit_user') ?>

    <div class="form-group">
        <?= Html::submitButton('Hľadať', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
