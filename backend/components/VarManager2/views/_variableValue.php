<?php
use yii\helpers\Html;

/* @var $varValue */
/* @var $type */
?>

<?php
$varValueModelName = \yii\helpers\StringHelper::basename($varValue->className());
$postIndex = rand(0, 10000000);
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
                        echo Html::activeTextarea($varValue, 'value', [
                            'class' => 'form-control',
                            'rows' => 5,
                            'placeholder' => $varValue->var->name,
                            'name' => $varValueModelName . '[' . $postIndex . '][value]',
                        ]);
                        break;
                    default:
                        echo Html::activeTextInput($varValue, 'value', [
                            'class' => 'form-control',
                            'name' => $varValueModelName . '[' . $postIndex . '][value]',
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

<?php
$js = <<<JS

$('.remove-btn').click(function () {
    $(this).parents('.variable-value').first().remove();
    // TODO put back deleted variable to dropdown
});

JS;
$this->registerJs($js); //, \yii\web\View::POS_BEGIN);
?>