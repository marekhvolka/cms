<?php

/* @var $this yii\web\View */
/* @var $snippetVar backend\models\Variable */

use backend\models\VarType;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;

?>

<li class="item variable panel panel-default var-id-<?= $snippetVar->id; ?>"><!-- widgetBody -->

    <div class="panel-heading form-inline">
        <label class="control-label" for="snippetvar-identifier">
            <?= $snippetVar->getAttributeLabel('identifier'); ?>
        </label>
        <?php
        $arrayFirstDimensionValue = $snippetVar->id ? : 'placeholder';
        echo BaseHtml::activeTextInput($snippetVar, "identifier", [
            'maxlength' => true,
            'class' => 'form-control var-identifier attribute',
            'data-attribute-name' => 'identifier',
            'name' => "SnippetVar[$arrayFirstDimensionValue][identifier]",
        ]);
        ?>

        <button type="button" class="remove-item-vars btn btn-danger btn-xs pull-right" 
                data-var-id="<?= $snippetVar->id; ?>">
            <i class="glyphicon glyphicon-minus"></i>
        </button>
    </div>
    <div class="panel-body">

        <div class="row">
            <div class="col-sm-12">

            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <label class="control-label" for="snippetvar-type_id">
                    <?= $snippetVar->getAttributeLabel('variable_type_id'); ?>
                </label>
                <?php
                $allVars = VarType::find()->where(['show_snippet' => 1])->all();
                $data = ArrayHelper::map($allVars, 'id', 'label');
                
                echo BaseHtml::activeDropDownList($snippetVar, 'type_id', $data, [
                    'class' => 'form-control select-var-type attribute',
                    'prompt'=>'Vyber typ premennej',
                    'data-attribute-name' => 'type_id',
                    'name' => "SnippetVar[$arrayFirstDimensionValue][type_id]",
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
                    'class' => 'form-control var-default-value attribute',
                    'data-attribute-name' => 'default_value',
                    'name' => "SnippetVar[$arrayFirstDimensionValue][default_value]",
                    ]);?>
            </div>
        </div>

        <?= BaseHtml::hiddenInput("SnippetVar[$arrayFirstDimensionValue][parent_id]", 
                $snippetVar->parent_id ? : '', [
            'class' => 'parent-id attribute',
            'data-attribute-name' => 'parent_id',
            ]); ?>
        
        <?= BaseHtml::hiddenInput("SnippetVar[$arrayFirstDimensionValue][id]", $snippetVar->id, [
            'class' => 'item-id attribute',
            'data-attribute-name' => 'id',
            ]); ?>
        
        <?= BaseHtml::hiddenInput("SnippetVar[$arrayFirstDimensionValue][existing]",
                $snippetVar->id ? 'true' : 'false', [
            'class' => 'existing attribute',
            'data-attribute-name' => 'existing',
            ]); ?>
        
        <div class="row">
            <div class="col-sm-12">
                <label class="control-label" for="snippetvar-default_value">
                    <?= $snippetVar->getAttributeLabel('description'); ?>
                </label>
                <?= BaseHtml::activeTextarea($snippetVar, "description", [
                    'rows' => '4', 
                    'class' => 'form-control var-description attribute',
                    'data-attribute-name' => 'description',
                    'name' => "SnippetVar[$arrayFirstDimensionValue][description]",
                    ]);?>
            </div>
        </div>
        
        <div class="row child-var" <?= (isset($snippetVar->type) && $snippetVar->type->identifier == 'list') ? '' : 'hidden="hidden"' ?>>
            <div class="col-sm-12">
                <div class="panel panel-default" id="list_19604" style="display: block; position: relative;">
                    <div class="panel-heading">
                        Premenné pre položku zoznamu

                        <button type="button" class="btn btn-success btn-xs btn-add-var pull-right"
                                data-toggle="dropdown" aria-expanded="false" title="Pridať premennú"
                                onclick="">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                    </div>
                    <div class="panel-body">
                        <input type="hidden" value="0" id="">
                        <ul style="list-style: none;" class="container-items-vars">
                            <?php foreach ($snippetVar->children as $child) : ?>
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
</li>

<?php

$js = <<<JS

// Last remove button was clicked - last form must be cleared.
$('.remove-item-vars').bind('click', function() {
    $(this).parents('li').first().remove();
});     
        
JS;
$this->registerJs($js);
?>
