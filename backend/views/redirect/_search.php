<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\RedirectSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="redirect-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'disable-are-you-sure'
        ]
    ]); ?>

    <?= $form->field($model, 'globalSearch') ?>

    <?php ActiveForm::end(); ?>

</div>
