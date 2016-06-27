<?php

use backend\components\IdentifierGenerator\IdentifierGenerator;
use backend\models\Product;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Language;
use kartik\switchinput\SwitchInput;
use backend\models\ProductType;
use backend\components\VarManager\VarManagerWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $allVariables backend\models\ProductVar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'identifier')->textInput(['maxlength' => true]) ?>

    <?= IdentifierGenerator::widget([
        'idTextFrom' => 'product-name',
        'idTextTo' => 'product-identifier',
        'delimiter' => '_',
    ]) ?>

    <?= $form->field($model, 'parent_id')->dropDownList(
        ArrayHelper::map(Product::find()->all(), 'id', 'name'), [
            'prompt' => 'Vyber predka'
        ]
    ) ?>

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

    <?= VarManagerWidget::widget([
        'allVariables' => $allVariables,
        'assignedVariableValues' => $model->productVarValues,
        'appendVarValueUrl' => Url::to(['product/append-var-value']),
        'model' => $model
    ]) ?>

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

    <?php ActiveForm::end(); ?>
