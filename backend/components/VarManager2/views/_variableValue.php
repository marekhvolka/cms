<?php
use yii\helpers\Html;

/* @var $varValue */
/* @var $type */
?>

<div class="form-group field-<?=$varValue->var_id?> active-field">
    <label class="col-sm-2 control-label label-var"><?=$varValue->var->name?></label>
    <div class="col-sm-10 var-value">
        <div class="input-group">
            <?php if($varValue->var->description): ?>
                <span class="input-group-addon">
                    <a class='my-tool-tip' data-toggle="tooltip" data-placement="left" title="<?=$varValue->var->description?>">
                        <!-- The class CANNOT be tooltip... -->
                        <i class='glyphicon glyphicon-question-sign'></i>
                    </a>
                </span>
            <?php endif;?>
            <?php switch($varValue->var->type->identifier):
                case 'textarea': ?>
                    <?=Html::activeTextarea($varValue, 'value', [
                        'class' => 'form-control',
                        'rows' => 5,
                        'placeholder' => $varValue->var->name,
                    ])?>
            
            
                    <?php break; ?>
                <?php default: ?>
                    <?=Html::activeTextInput($varValue, 'value', [
                        'class' => 'form-control',
                        'placeholder' => $varValue->var->name,
                    ])?>
                  
                    <?php break; ?>
                <?php endswitch; ?>
            <span class="input-group-btn rmv-btn" data-field-id="<?=$varValue->var_id?>">
                <button class="btn btn-danger remove-field" type="button" >
                    <span class="glyphicon glyphicon-remove"></span>
                </button>
            </span>
        </div>
    </div>
</div>
