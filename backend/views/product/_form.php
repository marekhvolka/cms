<?php

use backend\models\ProductVar;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Product;
use backend\models\Language;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use backend\models\ProductType;


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
    
    <div id="dynamic-fields" class="row">
        <div id="starting-point"></div>
    </div>
    
    <?php 
    $vars = ProductVar::find()->all();
    echo Html::dropDownList('types', null,
      ArrayHelper::map($vars, 'id', 'name'), ['id' => 'types-dropdown']);
    
    ?>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<input type="text" id="test">


<div id="input-types-list">
    <?php foreach ($vars as $i => $var):?>

    <?php switch($var->type->type): 
    case 'Input': ?>
        <input type="text" id="field-<?=$var->id?>" class="form-control hidden" 
               value="" name="product_var[<?=$var->id?>][]" placeholder="<?=$var->name?>" 
               data-type="<?=$var->type->type?>">
        <?php break; ?>
    <?php case 'Číslo': ?>
        <input type="text" id="field-<?=$var->id?>" class="form-control hidden" 
               value="" name="product_var[<?=$var->id?>][]" placeholder="<?=$var->name?>" 
               data-type="<?=$var->type->type?>">
        <?php break; ?>
    <?php case 'Textarea': ?>
        <textarea id="field-<?=$var->id?>" class="form-control hidden" rows="5" 
                  name="product_var[<?=$var->id?>][]" placeholder="<?=$var->name?>" 
                  data-type="<?=$var->type->type?>"></textarea>
        <?php break; ?>
    <?php endswitch; ?>
    
    <?php endforeach;?>
</div>


<div id="test">
    <?php foreach ($vars as $i => $var):?>
    <?=$var->name?>--->
    <?=$var->type->type?>
    <br/>
    <?php endforeach;?>
</div>

<?php

$js = <<<JS
        
$('[value="4"]').addClass('hidden');

$('#types-dropdown').change(function(){
    var fieldId = $(this).val();
    var source = $('#field-' + fieldId);
    source.removeClass('hidden');
        console.log(source);
    source.appendTo('#dynamic-fields');
});
        
JS;
$this->registerJs($js);
?>