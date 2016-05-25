<?php

/* @var $this yii\web\View */
/* @var $snippetVar backend\models\Variable */

use backend\models\VarType;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;

?>
<?php
$postIndex = rand(0, 10000000); // Index for correctly indexing Post request variable.
?>

<div class="item panel panel-default snippet-var var-id-<?= $snippetVar->id; ?>"><!-- widgetBody -->

    <div class="panel-heading form-inline">
        <label class="control-label" for="snippetvar-identifier">
            <?= $snippetVar->getAttributeLabel('identifier'); ?>
        </label>
        <?php
        $postIndex = $snippetVar->id ? : 'placeholder';
        echo BaseHtml::activeTextInput($snippetVar, "identifier", [
            'maxlength' => true,
            'class' => 'form-control',
            'name' => "SnippetVar[$postIndex][identifier]",
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
                    Typ premennej
                </label>
                <?php
                $allVars = VarType::find()->where(['show_snippet' => 1])->all();
                $data = ArrayHelper::map($allVars, 'id', 'name');
                
                echo BaseHtml::activeDropDownList($snippetVar, 'type_id', $data, [
                    'class' => 'form-control select-var-type',
                    'prompt'=>'Vyber typ premennej',
                    'name' => "SnippetVar[$postIndex][type_id]",
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
                    'class' => 'form-control',
                    'name' => "SnippetVar[$postIndex][default_value]",
                    ]);?>
            </div>
        </div>

        <?= BaseHtml::hiddenInput("SnippetVar[$postIndex][parent_id]", 
                $snippetVar->parent_id ? : ''); ?>
        
        <?= BaseHtml::hiddenInput("SnippetVar[$postIndex][id]", $snippetVar->id); ?>
        
        <?= BaseHtml::hiddenInput("SnippetVar[$postIndex][existing]", $snippetVar->id ? 'true' : 'false'); ?>
        
        <div class="row">
            <div class="col-sm-12">
                <label class="control-label" for="snippetvar-default_value">
                    <?= $snippetVar->getAttributeLabel('description'); ?>
                </label>
                <?= BaseHtml::activeTextarea($snippetVar, "description", [
                    'rows' => '4', 
                    'class' => 'form-control',
                    'name' => "SnippetVar[$postIndex][description]",
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
</div>

<?php

$js = <<<JS

// Last remove button was clicked - last form must be cleared.
$('.remove-item-vars').bind('click', function() {
    $(this).parents('li').first().remove();
});     
        
JS;
$this->registerJs($js);
?>
