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
    $varsData = ArrayHelper::map($vars, 'id', 'name');

    echo '<label class="control-label">Variables</label>';
    echo Select2::widget([
        'name' => 'product_vars',
        'data' => $varsData,
        'options' => [
            'placeholder' => 'Select var ...',
            'id' => 'types-dropdown',
        ],
    ]);
    
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<div id="input-types-list">
    <?php foreach ($vars as $i => $var):?>
    <div class="hidden field-<?=$var->id?>">
    <?php switch($var->type->type): 
    case 'Input': ?>
        <input type="text" class="form-control" 
               value="" name="product_var[<?=$var->id?>][]" placeholder="<?=$var->name?>" 
               data-type="<?=$var->type->type?>" data-name="<?=$var->name?>">
        <?php break; ?>
    <?php case 'Číslo': ?>
        <input type="text" id="field-<?=$var->id?>" class="form-control hidden" 
               value="" name="product_var[<?=$var->id?>][]" placeholder="<?=$var->name?>" 
               data-type="<?=$var->type->type?>" data-name="<?=$var->name?>">
        <?php break; ?>
    <?php case 'Textarea': ?>
        <textarea id="field-<?=$var->id?>" class="form-control hidden" rows="5" 
                  name="product_var[<?=$var->id?>][]" placeholder="<?=$var->name?>" 
                  data-type="<?=$var->type->type?>" data-name="<?=$var->name?>"></textarea>
        <?php break; ?>
    <?php endswitch; ?>
    <span class="input-group-btn rmv-btn" data-field-id="<?=$var->id?>">
        <button class="btn btn-danger remove-field" type="button" >
        <span class="glyphicon glyphicon-remove"></span></button>
    </span>
    </div>
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
    var source = $('.field-' + fieldId);
    var sourceClone = source.clone(true, true);
    sourceClone.removeClass('hidden');
    sourceClone.addClass('active-field');
        
    sourceClone.appendTo('#dynamic-fields');
});
        
   $('.rmv-btn').click(function() {
        var id = $(this).attr('data-field-id');
        var elementClass = '.field-' + id + '.active-field';
        $(elementClass).remove();
   
   })
        
JS;
$this->registerJs($js);
?>