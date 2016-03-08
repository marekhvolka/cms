<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Snippet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="snippet-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'popis')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'default_code_id')->textInput() ?>

    <?= $form->field($model, 'typ_snippet')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <?= $form->field($model, 'sekcia_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sekcia_class')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sekcia_style')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'block_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'block_class')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'block_style')->textInput(['maxlength' => true]) ?>

    <div class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Alternatívy</h4></div>
        <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsSnippetCode[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'full_name',
                    'address_line1',
                    'address_line2',
                    'city',
                    'state',
                    'postal_code',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
                <?php foreach ($modelsSnippetCode as $i => $modelSnippetCode): ?>
                    <div class="item panel panel-default"><!-- widgetBody -->
                        <div class="panel-heading">
                            <div class="input-group">
                                <?= $form->field($modelSnippetCode, "[{$i}]name")->textInput(['maxlength' => true]) ?>
                                <div class="pull-right">
                                    <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                    <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php
                            // necessary for update action.
                            if (! $modelSnippetCode->isNewRecord) {
                                echo Html::activeHiddenInput($modelSnippetCode, "[{$i}]id");
                            }
                            ?>

                            <div class="row">
                                <div class="col-sm-12">
                                    <?= $form->field($modelSnippetCode, "[{$i}]code")->textarea(['maxlength' => true]) ?>
                                </div>
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <?= $form->field($modelSnippetCode, "[{$i}]popis")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
