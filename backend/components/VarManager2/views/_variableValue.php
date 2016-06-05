<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $varValue */
?>

<?php
// Name of model class without path for creating name attributes for inputs 
// used in post request parameters in form and eventually in controller.
$varValueModelName = \yii\helpers\StringHelper::basename($varValue->className());
$postIndex = rand(0, 10000000); // Index for correctly indexing Post request variable.
?>

<div class="form-group variable-value active-field">
    <label class="col-sm-2 control-label label-var"><?=$varValue->var->name?></label>
    <div class="col-sm-10 var-value">
        <div class="input-group">
            <?= Html::activeHiddenInput($varValue, 'id', [
                'name' => $varValueModelName . '[' . $postIndex . '][id]'
                ]);?>
            <?= Html::activeHiddenInput($varValue, 'var_id', [
                'name' => $varValueModelName . '[' . $postIndex . '][var_id]'
                ]);?>
            <?= Html::activeHiddenInput($varValue, 'product_id', [
                'name' => $varValueModelName . '[' . $postIndex . '][product_id]'
                ]);?>
            
            <?= Html::hiddenInput($varValueModelName . '[' . $postIndex . '][existing]',
                $varValue->id ? 'true' : 'false'); ?>
            
            <?php if($varValue->var->description): ?>
                <span class="input-group-addon">
                    <a class='my-tool-tip' data-toggle="tooltip" data-placement="left" 
                       title="<?=$varValue->var->description?>">
                        <!-- The class CANNOT be tooltip... -->
                        <i class='glyphicon glyphicon-question-sign'></i>
                    </a>
                </span>
            <?php endif;?>
            <?php
                switch($varValue->var->type->identifier) {
                    case 'textarea':
                        echo Html::activeTextarea($varValue, 'value_text', [
                            'class' => 'form-control',
                            'rows' => 5,
                            'placeholder' => $varValue->var->name,
                            'name' => $varValueModelName . '[' . $postIndex . '][value_text]',
                        ]);
                        break;
                    default:
                        echo Html::activeTextInput($varValue, 'value_text', [
                            'class' => 'form-control',
                            'name' => $varValueModelName . '[' . $postIndex . '][value_text]',
                        ]);
                        break;
                }
            ?>
            
            <span class="input-group-btn remove-btn">
                <button class="btn btn-danger remove-var-value" type="button" >
                    <span class="glyphicon glyphicon-remove"></span>
                </button>
            </span>
        </div>
    </div>
</div>
