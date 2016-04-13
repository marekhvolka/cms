<?php

/* @var $this yii\web\View */

use yii\helpers\ArrayHelper;
use backend\models\VarType;


?>
<div class="item panel panel-default"><!-- widgetBody -->
    <button type="button" class="remove-item-vars btn btn-danger btn-xs">
        <i class="glyphicon glyphicon-minus"></i>
    </button>

    <div class="panel-body">

        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($snippetVar, "identifier")->textInput(['maxlength' => true, 'class' => 'form-control var-identifier']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?php
                $allVars = VarType::find()->where(['show_snippet' => 1])->all();
                $data = ArrayHelper::map($allVars, 'id', 'type');

                echo $form->field($snippetVar, "type_id")->dropDownList($data, ['prompt'=>'Select...']);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($snippetVar, "default_value")->textInput(['class' => 'form-control var-default-value']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($snippetVar, "description")->textarea(['rows' => '4', 'class' => 'form-control var-description']) ?>
            </div>
        </div>
        
        <?php if($snippetVar->type->type == 'list'): ?>
        <div class="col-sm-11 col-sm-offset-1">
            
        </div>
        <?php endif; ?>
    </div>
</div>
