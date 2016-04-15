<?php

/* @var $this yii\web\View */
/* @var $snippetVar backend\models\SnippetVar */

use yii\helpers\ArrayHelper;
use backend\models\VarType;
use yii\helpers\Html;

?>
<div class="item panel panel-default"><!-- widgetBody -->
    <button type="button" class="remove-item-vars btn btn-danger btn-xs">
        <i class="glyphicon glyphicon-minus"></i>
    </button>

    <div class="panel-body">

        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($snippetVar, "identifier")->textInput(['maxlength' => true, 
                    'class' => 'form-control var-identifier',
                    'name' => "SnippetVar[$snippetVar->id][identifier]",
                    ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?php
                $allVars = VarType::find()->where(['show_snippet' => 1])->all();
                $data = ArrayHelper::map($allVars, 'id', 'type');

                echo $form->field($snippetVar, "type_id")->dropDownList($data, [
                    'prompt'=>'Select...',
                    'name' => "SnippetVar[$snippetVar->id][type_id]",
                    ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($snippetVar, "default_value")->textInput([
                    'class' => 'form-control var-default-value',
                    'name' => "SnippetVar[$snippetVar->id][default_value]",
                    ]) ?>
            </div>
        </div>

        <?php if($snippetVar->parent_id): ?>
        <?= Html::hiddenInput("SnippetVar[$snippetVar->id][parent_id]", $snippetVar->parent_id); ?>
        <?php endif;?>
        
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($snippetVar, "description")->textarea([
                    'rows' => '4', 
                    'class' => 'form-control var-description',
                    'name' => "SnippetVar[$snippetVar->id][description]",
                    ]) ?>
            </div>
        </div>
        
        <?php if($snippetVar->type->type == 'list'): ?>
        <div class="col-sm-11 col-sm-offset-1">
            <div class="panel panel-default" id="list_19604" style="display: block; position: relative;">
                <button type="button" class="btn btn-success btn-xs btn-remove-var" 
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
                            <?= $this->render('_variable', ['snippetVar' => $child, 'form' => $form]); ?>
                        </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
