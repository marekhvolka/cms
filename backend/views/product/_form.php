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
    
    <input type="hidden" id="input-types" name="input-types">

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['id' => 'save-model', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<div id="input-types-list">
    <?php foreach ($vars as $i => $var):?>
    <div class="hidden field-<?=$var->id?>">
    <?php switch($var->type->type): 
    case 'Input': ?>
        <input type="text" class="form-control" 
               value="" placeholder="<?=$var->name?>" 
               data-type="<?=$var->type->type?>" data-name="<?=$var->name?>">
        <?php break; ?>
    <?php case 'Číslo': ?>
        <input type="text" id="field-<?=$var->id?>" class="form-control hidden" 
               value="" placeholder="<?=$var->name?>" 
               data-type="<?=$var->type->type?>" data-name="<?=$var->name?>">
        <?php break; ?>
    <?php case 'Textarea': ?>
        <textarea id="field-<?=$var->id?>" class="form-control hidden" rows="5" 
                  placeholder="<?=$var->name?>" 
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

<?php

$typesDataJs = '{';

for ($i = 0; $i < sizeof($vars); $i++) {
    $dataObject = '' . $vars[$i]->id .  ': "' . $vars[$i]->name . '"';
    if ($i != sizeof($vars) - 1) {
        $dataObject .= ',';
    }
    
    $typesDataJs .= $dataObject;
}

$typesDataJs .= '}';

$js = <<<JS

var typesData = $typesDataJs;

$('#types-dropdown').change(function(){
    var fieldId = $(this).val();
    var source = $('.field-' + fieldId);
    var sourceClone = source.clone(true, true);
    sourceClone.removeClass('hidden');
    sourceClone.addClass('active-field');
        
    sourceClone.appendTo('#dynamic-fields');
    sourceClone.find('input').attr('name', 'product_var[' + fieldId + '][]');
        
    $('#types-dropdown').find('[value="' + fieldId + '"]').remove();
});
        
$('.rmv-btn').click(function() {
    var id = $(this).attr('data-field-id');
    var elementClass = '.field-' + id + '.active-field';
    $(elementClass).remove();

    var newChild = '<option value="' + id + '">' + typesData[id] + '</option>';
    $('#types-dropdown').append(newChild);
        
    $('#types-dropdown').find('option').sort(function(a, b) {
        return +a.getAttribute('value') - +b.getAttribute('value');
    })
    .appendTo($('#types-dropdown'));
        
    $('#types-dropdown').find('option').attr('aria-selected', "false");
});

$('#save-model').click(function() {
//    var types = [];
//    $('.active-field').each(function(i, obj) {
//        $(obj).
//    });
//        
//    test = JSON.stringify( ["Hello", "World"] );
//    $('#input-types').val(test);
    return true;
});
        
      
JS;
$this->registerJs($js);
?>