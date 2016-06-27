<?php

use backend\models\PortalVar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\models\Template;
use yii\helpers\ArrayHelper;
use backend\models\Language;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use backend\components\VarManager\VarManagerWidget;

/* @var $this yii\web\View */
/* @var $model backend\models\Portal */
/* @var $form yii\widgets\ActiveForm */
/* @var $allVariables backend\models\PortalVar */
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

    <?= $form->field($model, 'color_scheme')->textInput() ?>

    <?= $form->field($model, 'active')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <?= $form->field($model, 'published')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <?= $form->field($model, 'cached')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <?= VarManagerWidget::widget([
        'allVariables' => $allVariables,
        'assignedVariableValues' => $model->portalVarValues,
        'appendVarValueUrl' => Url::to(['portal/append-var-value']),
        'model' => $model
    ])?>

    <div class="navbar-fixed-bottom">
        <div class="col-sm-10 col-sm-offset-2">
            <div class="form-group">
                <?= Html::submitButton('Uložiť', [
                    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                    'id' => 'submit-btn'
                ]) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
