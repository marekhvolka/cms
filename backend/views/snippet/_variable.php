<?php

/* @var $this yii\web\View */
/* @var $snippetVar backend\models\SnippetVar */

use yii\helpers\ArrayHelper;
use backend\models\VarType;
use yii\helpers\BaseHtml;

?>

<div class="item panel panel-default var-id-<?= $snippetVar->id; ?>"><!-- widgetBody -->
    <button type="button" class="remove-item-vars btn btn-danger btn-xs" data-var-id="<?= $snippetVar->id; ?>">
        <i class="glyphicon glyphicon-minus"></i>
    </button>

    <div class="panel-body">

        <div class="row">
            <div class="col-sm-12">
                <label class="control-label" for="snippetvar-identifier">
                    <?= $snippetVar->getAttributeLabel('identifier'); ?>
                </label>
                <?php
                    $arrayFirstDymensionValue = $snippetVar->id ? : 'new';
                    echo BaseHtml::activeTextInput($snippetVar, "identifier", ['maxlength' => true, 
                    'class' => 'form-control var-identifier',
                    'name' => "SnippetVar[$arrayFirstDymensionValue][identifier]",
                    ]);?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <label class="control-label" for="snippetvar-type_id">
                    <?= $snippetVar->getAttributeLabel('type_id'); ?>
                </label>
                <?php
                $allVars = VarType::find()->where(['show_snippet' => 1])->all();
                $data = ArrayHelper::map($allVars, 'id', 'type');
                
                echo BaseHtml::activeDropDownList($snippetVar, 'type_id', $data, [
                    'class' => 'form-control select-var-type',
                    'prompt'=>'Select...',
                    'name' => "SnippetVar[$arrayFirstDymensionValue][type_id]",
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <label class="control-label" for="snippetvar-default_value">
                    <?= $snippetVar->getAttributeLabel('default_value'); ?>
                </label>
                <?= BaseHtml::activeTextInput($snippetVar, "default_value", [
                    'class' => 'form-control var-default-value',
                    'name' => "SnippetVar[$arrayFirstDymensionValue][default_value]",
                    ]);?>
            </div>
        </div>

        <?php if($snippetVar->parent_id): ?>
        <?= BaseHtml::hiddenInput("SnippetVar[$arrayFirstDymensionValue][parent_id]", $snippetVar->parent_id); ?>
        <?php endif;?>
        
        <?= BaseHtml::hiddenInput("SnippetVar[$arrayFirstDymensionValue][id]", $snippetVar->id); ?>
        
        <div class="row">
            <div class="col-sm-12">
                <label class="control-label" for="snippetvar-default_value">
                    <?= $snippetVar->getAttributeLabel('description'); ?>
                </label>
                <?= BaseHtml::activeTextarea($snippetVar, "description", [
                    'rows' => '4', 
                    'class' => 'form-control var-description',
                    'name' => "SnippetVar[$arrayFirstDymensionValue][description]",
                    ]);?>
            </div>
        </div>
        
        <div class="row child-var" <?= (isset($snippetVar->type) && $snippetVar->type->type == 'list') ? '' : 'hidden="hidden"' ?>>
            <div class="col-sm-11 col-sm-offset-1">
                <div class="panel panel-default" id="list_19604" style="display: block; position: relative;">
                    <button type="button" class="btn btn-success btn-xs btn-add-var" 
                            data-toggle="dropdown" aria-expanded="false" title="Pridať premennú" 
                            onclick="">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                    <div class="panel-heading">Premenné pre položku zoznamu</div>
                    <div class="panel-body">
                        <input type="hidden" value="0" id="">
                        <ul id="">
                            <?php foreach ($snippetVar->children as $child):?>
                            <li>
                                <?= $this->render('_variable', ['snippetVar' => $child]); ?>
                            </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php

$js = <<<JS

// Last remove button was clicked - last form must be cleared.
$('.remove-item-vars').bind('click', function() {
    var varId = $(this).attr('data-var-id');
    $('.var-id-' + varId).remove();
});     
        

        

        
JS;
$this->registerJs($js);
?>
