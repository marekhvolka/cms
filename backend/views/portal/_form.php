<?php

use backend\models\PortalVar;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Template;
use yii\helpers\ArrayHelper;
use backend\models\Language;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Portal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="portal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'language_id')->dropDownList(
        ArrayHelper::map(Language::find()->all(), 'id', 'name')
    ) ?>

    <?= $form->field($model, 'domain')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'template_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Template::find()->all(), 'id', 'name'),
        'language' => 'en',
        'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'template_settings')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <?= $form->field($model, 'published')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <?= $form->field($model, 'cached')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <div class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Premenné portálu</h4></div>
        <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsPortalVarValue[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'value',
                    'name',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
                <?php foreach ($modelsPortalVarValue as $i => $modelPortalVarValue): ?>
                    <div class="item panel panel-default"><!-- widgetBody -->
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <?= $form->field($modelPortalVarValue, '[{$i}]var_id')->dropDownList(
                                        ArrayHelper::map(PortalVar::find()->all(), 'id', 'name')
                                    ) ?>
                                </div>
                                <div class="col-sm-6">
                                    <?= $form->field($modelPortalVarValue, "[{$i}]value")->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-sm-3">
                                    <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                    <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <?php
                            // necessary for update action.
                            if (! $modelPortalVarValue->isNewRecord) {
                                echo Html::activeHiddenInput($modelPortalVarValue, "[{$i}]id");
                            }
                            ?>
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
