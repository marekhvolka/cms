<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\LayoutWidget;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dictionary-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= LayoutWidget::widget()?>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
