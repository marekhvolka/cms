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

    <?= $form->field($model, 'nazov_system')->textInput(['maxlength' => true]) ?>

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

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
