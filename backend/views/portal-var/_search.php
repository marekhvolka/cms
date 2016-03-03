<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PortalVarSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="portal-var-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'vlastnost') ?>

    <?= $form->field($model, 'identifikator') ?>

    <?= $form->field($model, 'popis') ?>

    <?= $form->field($model, 'type_id') ?>

    <?php // echo $form->field($model, 'last_edit') ?>

    <?php // echo $form->field($model, 'last_edit_user') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
