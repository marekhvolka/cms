<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\DictionarySearch */
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

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>

</div>
