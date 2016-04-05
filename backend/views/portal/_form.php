<?php

use backend\models\PortalVar;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Template;
use yii\helpers\ArrayHelper;
use backend\models\Language;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Portal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="portal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'language_id')->dropDownList(
        ArrayHelper::map(Language::find()->all(), 'id', 'name')
    ) ?>

    <?= $form->field($model, 'domain')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'template_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Template::find()->all(), 'id', 'name'),
        'language' => 'en',
        'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'template_settings')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <?= $form->field($model, 'published')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <?= $form->field($model, 'cached')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <?php 
    
    $all_variables = PortalVar::find()->all();
    
    if ($model->id) {
        $selected_var_values = $model->portalVarValues;
    }
    
    $all_variables_data = ArrayHelper::map($all_variables, 'id', 'name');
    
    ?>
   
    <div id="dynamic-fields" class="row">
        <?php if(isset($selected_var_values)):?>
            <?php foreach ($selected_var_values as $i => $var_value):?>
            <div class="form-group field-<?=$var_value->var_id?> active-field">
                <label class="col-sm-2 control-label label-var"><?=$var_value->var->name?></label>
                <div class="col-sm-10 var-value">
                    <div class="input-group">
                        <?php if($var_value->var->popis): ?>
                        <span class="input-group-addon">
                            <a class='my-tool-tip' data-toggle="tooltip" data-placement="left" title="<?=$var_value->var->popis?>">
                                <!-- The class CANNOT be tooltip... -->
                                <i class='glyphicon glyphicon-question-sign'></i>
                            </a>
                        </span>
                        <?php endif;?>
                        <?php switch($var_value->var->type->type): 
                        case 'textarea': ?>
                            <textarea id="field-<?=$var_value->var_id?>" class="form-control" rows="5" 
                                      placeholder="<?=$var_value->var->name?>" 
                                      data-type="<?=$var_value->var->type->type?>" data-name="<?=$var_value->var->name?>"
                                      name="var[<?=$var_value->var_id?>][]">
                                      <?=$var_value->value?>
                            </textarea>
                            <?php break; ?>
                        <?php default: ?>
                            <input type="text" class="form-control" 
                                   value="<?=$var_value->value?>" placeholder="<?=$var_value->var->name?>" 
                                   data-type="<?=$var_value->var->type->type?>" data-name="<?=$var_value->var->name?>"
                                   name="var[<?=$var_value->var_id?>][]">
                            <?php break; ?>
                        <?php endswitch; ?>
                        <span class="input-group-btn rmv-btn" data-field-id="<?=$var_value->var_id?>">
                            <button class="btn btn-danger remove-field" type="button" >
                            <span class="glyphicon glyphicon-remove"></span></button>
                        </span>   
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        <?php endif;?>
    </div>
    
    <?php

    echo '<label class="control-label">Variables</label>';
    echo Select2::widget([
        'name' => 'vars',
        'data' => $all_variables_data,
        'options' => [
            'placeholder' => 'Select var ...',
            'id' => 'types-dropdown',
        ],
    ]);
    
    ?>
    
    <input type="hidden" id="input-types" name="input-types">

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div id="input-types-list">
    <?php foreach ($all_variables as $i => $var):?>
    <div class="form-group hidden field-<?=$var->id?>">
        <label class="col-sm-2 control-label label-var"><?=$var->name?></label>
        <div class="col-sm-10 var-value">
            <div class="input-group">
                <?php if($var->popis): ?>
                <span class="input-group-addon">
                    <a class='my-tool-tip' data-toggle="tooltip" data-placement="left" title="<?=$var->popis?>">
                        <!-- The class CANNOT be tooltip... -->
                        <i class='glyphicon glyphicon-question-sign'></i>
                    </a>
                </span>
                <?php endif;?>
                <?php switch($var->type->type): 
                case 'textarea': ?>
                    <textarea id="field-<?=$var->id?>" class="form-control" rows="5" 
                              placeholder="<?=$var->name?>" 
                              data-type="<?=$var->type->type?>" data-name="<?=$var->name?>"></textarea>
                    <?php break; ?>
                <?php default: ?>
                    <input type="text" class="form-control" 
                           value="" placeholder="<?=$var->name?>" 
                           data-type="<?=$var->type->type?>" data-name="<?=$var->name?>">
                    <?php break; ?>
                <?php endswitch; ?>
                <span class="input-group-btn rmv-btn" data-field-id="<?=$var->id?>">
                    <button class="btn btn-danger remove-field" type="button" >
                    <span class="glyphicon glyphicon-remove"></span></button>
                </span>   
            </div>
        </div>
    </div>
    <?php endforeach;?>
</div>

<?php

// Additional javascript (will be injected into js code).
// List of variables data - id and name.
$vars_data_js = '{';
// Concatening of string which will be used as javascript code.
for ($i = 0; $i < sizeof($all_variables); $i++) {
    $data_object = '' . $all_variables[$i]->id .  ': "' . $all_variables[$i]->name . '"';
    if ($i != sizeof($all_variables) - 1) {
        $data_object .= ',';
    }
    
    $vars_data_js .= $data_object;
}
$vars_data_js .= '}';


// Additional javascript (will be injected into js code).
// Array of IDs of product variables which was allready set to product.
$selected_var_values_js = '[]';

// IDs of selected product variables.
if (isset($selected_var_values)) {  // Update of product which have set variables.
    $selected_var_values_ids = ArrayHelper::getColumn($selected_var_values, 'var_id');
    $selected_var_values_js = '[';
    // Concatening of string which will be used as javascript code.
    for ($i = 0; $i < sizeof($selected_var_values_ids); $i++) {
        $selected_var_values_js .= $selected_var_values_ids[$i];
        if ($i != sizeof($selected_var_values_ids) - 1) {
            $selected_var_values_js .= ',';
        }
    }
    $selected_var_values_js .= ']';
}

$js = <<<JS

var typesData = $vars_data_js;
var selectedVarIds = $selected_var_values_js;
        
for (var i = 0; i < selectedVarIds.length; i++) {
    $('#types-dropdown').find('[value="' + selectedVarIds[i] + '"]').remove();
}        

$('#types-dropdown').change(function(){
    var fieldId = $(this).val();
    var source = $('.field-' + fieldId);
    var sourceClone = source.clone(true, true);
    sourceClone.removeClass('hidden');
    sourceClone.addClass('active-field');
        
    sourceClone.appendTo('#dynamic-fields');
    sourceClone.find('input').attr('name', 'var[' + fieldId + '][]');
        
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
      
        
JS;
$this->registerJs($js);
?>