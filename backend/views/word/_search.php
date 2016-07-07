<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\search\WordSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dictionary-search">

    <?php Pjax::begin(['id' => 'search-form']); ?>
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['data-pjax' => true],
    ]); ?>

    <?= $form->field($model, 'globalSearch') ?>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>

</div>
