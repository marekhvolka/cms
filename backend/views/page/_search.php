<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'portal_id') ?>

    <?= $form->field($model, 'active') ?>

    <?php // echo $form->field($model, 'in_menu') ?>

    <?php // echo $form->field($model, 'parent_id') ?>

    <?php // echo $form->field($model, 'poradie') ?>

    <?php // echo $form->field($model, 'product_id') ?>

    <?php // echo $form->field($model, 'presmerovanie') ?>

    <?php // echo $form->field($model, 'utm') ?>

    <?php // echo $form->field($model, 'presmerovanie_aktivne') ?>

    <?php // echo $form->field($model, 'seo_title') ?>

    <?php // echo $form->field($model, 'seo_description') ?>

    <?php // echo $form->field($model, 'seo_keywords') ?>

    <?php // echo $form->field($model, 'layout_poradie') ?>

    <?php // echo $form->field($model, 'layout_poradie_id') ?>

    <?php // echo $form->field($model, 'layout_element') ?>

    <?php // echo $form->field($model, 'layout_element_type') ?>

    <?php // echo $form->field($model, 'layout_element_active') ?>

    <?php // echo $form->field($model, 'layout_element_time_from') ?>

    <?php // echo $form->field($model, 'layout_element_time_to') ?>

    <?php // echo $form->field($model, 'layout_color_scheme') ?>

    <?php // echo $form->field($model, 'sidebar') ?>

    <?php // echo $form->field($model, 'sidebar_side') ?>

    <?php // echo $form->field($model, 'sidebar_size') ?>

    <?php // echo $form->field($model, 'footer') ?>

    <?php // echo $form->field($model, 'header') ?>

    <?php // echo $form->field($model, 'last_edit') ?>

    <?php // echo $form->field($model, 'last_edit_user') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
