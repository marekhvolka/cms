<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SnippetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="snippet-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'popis') ?>

    <?= $form->field($model, 'default_code_id') ?>

    <?= $form->field($model, 'typ_snippet') ?>

    <?php // echo $form->field($model, 'sekcia_id') ?>

    <?php // echo $form->field($model, 'sekcia_class') ?>

    <?php // echo $form->field($model, 'sekcia_style') ?>

    <?php // echo $form->field($model, 'block_id') ?>

    <?php // echo $form->field($model, 'block_class') ?>

    <?php // echo $form->field($model, 'block_style') ?>

    <?php // echo $form->field($model, 'last_edit') ?>

    <?php // echo $form->field($model, 'last_edit_user') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
