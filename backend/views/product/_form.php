<?php

use backend\components\IdentifierGenerator\IdentifierGenerator;
use backend\models\ProductVar;
use backend\models\ProductVarValue;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Product;
use backend\models\Language;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use backend\models\ProductType;
use backend\components\VarManager2\VarManagerWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'identifier')->textInput(['maxlength' => true]) ?>

    <?=IdentifierGenerator::widget([
        'idTextFrom' => 'product-name',
        'idTextTo' => 'product-identifier',
        'delimiter' => '_',
    ])?>

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
    
    <?= yii\helpers\BaseHtml::textarea('Product[popis]', '', ['class' => 'form-controll', 'id' => 'product-popis'])?>
    
    

    <?= $form->field($model, 'language_id')->dropDownList(
        ArrayHelper::map(Language::find()->all(), 'id', 'name')
    ) ?>

    <?= $form->field($model, 'active')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>
    
    <?=VarManagerWidget::widget([
        'model' => $model,
        'form' => $form,
        'allVariables' => $allVariables,
        'assignedVariableValues' => $modelsProductVarValue,
        'variableValueClassName' => ProductVarValue::className(),
        'appendVarValueUrl' => Url::to(['product/append-var-value']),
    ])?>

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
