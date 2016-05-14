<?php

use backend\models\ProductVar;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Product;
use backend\models\Language;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use backend\models\ProductType;
use backend\components\VariableWidget;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'identifier')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Product::find()->all(), 'id', 'name'),
        'language' => 'en',
        'options' => ['placeholder' => 'Vyber rodiča ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'type_id')->dropDownList(
        ArrayHelper::map(ProductType::find()->all(), 'id', 'name')
    ) ?>

    <?= $form->field($model, 'popis')->textarea() ?>

    <?= $form->field($model, 'language_id')->dropDownList(
        ArrayHelper::map(Language::find()->all(), 'id', 'name')
    ) ?>

    <?= $form->field($model, 'active')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>
    
    <?=VariableWidget::widget(['type' => ProductVar::className(), 'model' => $model])?>

    <?php
        //TODO: Variable Widget nema mat save button
    ?>

    <div class="navbar-fixed-bottom">
        <div class="col-sm-10 col-sm-offset-2">
            <div class="form-group">
                <?= Html::submitButton('Uložiť', [
                    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                    'id' => 'submit-btn'
                ]) ?>
            </div>
        </div>
    </div>
