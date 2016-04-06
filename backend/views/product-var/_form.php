<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\VarType;
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

    <?= $form->field($model, 'popis')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_id')->dropDownList(
        ArrayHelper::map(VarType::find()->where(['show_product' => 1])->all(), 'id', 'type')
    ) ?>

    <label class="control-label" for="productvar-product_type">For Product Types</label>
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
        'id' => 'campaign-device',
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

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'id' => 'submit-form'
            ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>

<?php

//TODO refactoring - this may be validated by using Yii2 validation in model and controller
$js = <<<JS

$('#help-block-prod-types').hide();
$('#submit-form').click(function(){
    if ($('#campaign-device').val() == null) {
        $('#help-block-prod-types').show();
        return false;
    }
    $('#help-block-prod-types').hide();
    return true;
})
        
JS;
$this->registerJs($js);
?>