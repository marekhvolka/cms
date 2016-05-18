<?php

use backend\components\IdentifierGenerator\IdentifierGenerator;
use backend\models\VarType;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\ProductType;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductVar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-var-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'identifier')->textInput(['maxlength' => true]) ?>

    <?=IdentifierGenerator::widget([
        'idTextFrom' => 'productvar-name',
        'idTextTo' => 'productvar-identifier',
        'delimiter' => '_',
    ])?>

    <?= $form->field($model, 'description')->textArea(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_id')->dropDownList(
        ArrayHelper::map(VarType::find()->where(['show_product' => 1])->all(), 'id', 'label')
    ) ?>

    <label class="control-label" for="productvar-product_type">Zobrazovanie pre typy produktov: </label>
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
    
    <div class="help-block" id="help-block-prod-types" >
        <p style="color: #a94442;"><?= $model->getAttributeLabel('product_type')?> cannot be blank.</p>
    </div>

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
    
</div>

<?php
//TODO refactoring - this may be validated by using Yii2 validation in model and controller
$js = <<<JS

$('#help-block-prod-types').hide();
$('#submit-form').click(function(){
    if ($('#product_types').val() == null) {
        $('#help-block-prod-types').show();
        return false;
    }
    $('#help-block-prod-types').hide();
    return true;
})
        
JS;
$this->registerJs($js);
?>