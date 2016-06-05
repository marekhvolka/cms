<?php

use backend\models\VarType;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;

/* @var $this yii\web\View */
/* @var $snippetVar backend\models\SnippetVar */

$postIndex = rand(0, 10000000); // Index for correctly indexing Post request variable.
?>

<div class="item panel panel-default snippet-var"><!-- widgetBody -->

    <div class="panel-heading form-inline">
        <label class="control-label" for="snippetvar-identifier">
            <?= $snippetVar->getAttributeLabel('identifier'); ?>
        </label>
        <?= BaseHtml::activeTextInput($snippetVar, "identifier", [
            'maxlength' => true,
            'class' => 'form-control',
            'name' => "SnippetVar[$postIndex][identifier]",
        ]);
        ?>

        <button type="button" class="btn-remove-snippet-var btn btn-danger btn-xs pull-right" 
                data-var-id="<?= $snippetVar->id; ?>">
            <i class="glyphicon glyphicon-minus"></i>
        </button>
    </div>
    <div class="panel-body var-body">

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
        
        <?php
        if ($snippetVar->parent_id) {
            $parentId = $snippetVar->parent_id;
        }
        ?>

        <?= BaseHtml::hiddenInput("SnippetVar[$postIndex][parent_id]", 
                isset($parentId) ? $parentId : ''); ?>
        
        <?= BaseHtml::hiddenInput("SnippetVar[$postIndex][id]", $snippetVar->id ? $snippetVar->id : $postIndex, ['class' => 'variable-id']); ?>
        
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
        
        <?php if (isset($snippetVar->type) && $snippetVar->type->identifier == 'list'): ?>
        <?= $this->render('_child-var-box', ['snippetVar' => $snippetVar]); ?>
        <?php endif;?>
        
    </div>
</div>
