<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PortalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="portal-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'language_id') ?>

    <?= $form->field($model, 'domain') ?>

    <?= $form->field($model, 'template_id') ?>

    <?php // echo $form->field($model, 'template_settings') ?>

    <?php // echo $form->field($model, 'active') ?>

    <?php // echo $form->field($model, 'publikovana') ?>

    <?php // echo $form->field($model, 'cache') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
