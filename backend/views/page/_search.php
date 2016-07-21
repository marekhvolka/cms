<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\PageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-search">

    <?php $form = ActiveForm::begin([
        'action' => ['search'],
        'method' => 'get',
        'options' => [
            'class' => 'disable-are-you-sure'
        ]
    ]); ?>

    <?= $form->field($model, 'globalSearch') ?>

    <?= Html::submitButton('Hľadať', [
        'class' => 'btn btn-primary',
        'id' => 'submit-btn'
    ]) ?>

    <?php ActiveForm::end(); ?>

</div>
