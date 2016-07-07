<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;

use backend\models\ProductType;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Tag */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tag-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'identifier')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <label class="control-label" for="producttag-product_type">For Product Types</label>
    <?php
    $productTypes = ProductType::find()->all();
    $productTypesData = ArrayHelper::map($productTypes, 'id', 'name');

    $selectedProductTypes = $model->product_type ?
        ProductType::find()->where('id in (' . $model->product_type . ')')->all() : [];
    $selectedProductTypesData = ArrayHelper::map($selectedProductTypes, 'id', 'id');

    // TODO controller site saving process
    echo Select2::widget([
        'name' => 'product_type_ids',
        'value' => $selectedProductTypesData,
        'data' => $productTypesData,
        'id' => 'product_types',
        'options' => [
            'placeholder' => 'Select or type cover url ...',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'tags' => true,
        ],
    ]);

    ?>

    <div class="navbar-fixed-bottom">
        <div class="col-sm-10 col-sm-offset-2">
            <div class="form-group">
                <?= Html::submitButton('Uložiť', [
                    'class' => 'btn btn-primary',
                    'id' => 'submit-btn'
                ]) ?>

                <?= Html::submitButton('Uložiť a pokračovať', [
                    'class' => 'btn btn-info',
                    'id' => 'submit-btn',
                    'name' => 'continue'
                ]) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
