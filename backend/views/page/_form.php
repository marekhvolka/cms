<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Page;
use backend\models\Product;
use backend\models\Portal;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->widget(SwitchInput::classname(), [
    'type' => SwitchInput::CHECKBOX
    ]) ?>

    <?= $form->field($model, 'in_menu')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Page::find()->all(), 'id', 'name'),
        'language' => 'en',
        'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'product_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Product::find()->all(), 'id', 'name'),
    'language' => 'en',
    'options' => ['placeholder' => 'Select a state ...'],
    'pluginOptions' => [
    'allowClear' => true
    ],
    ]); ?>

    <?= $form->field($model, 'presmerovanie')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'utm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'presmerovanie_aktivne')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_description')->textarea() ?>

    <?= $form->field($model, 'seo_keywords')->textarea() ?>

    <?= $form->field($model, 'layout_poradie')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'layout_poradie_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'layout_element')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'layout_element_type')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'layout_element_active')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'layout_element_time_from')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'layout_element_time_to')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'color_scheme')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sidebar')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <?= $form->field($model, 'sidebar_side')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sidebar_size')->textInput() ?>

    <?= $form->field($model, 'footer')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <?= $form->field($model, 'header')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
