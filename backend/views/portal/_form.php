<?php

use backend\components\VarManager\VarManagerWidget;
use backend\models\Language;
use backend\models\Template;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Portal */
/* @var $form yii\widgets\ActiveForm */
/* @var $allVariables backend\models\PortalVar */
?>

<div class="portal-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form',
        'enableAjaxValidation' => true,
    ]); ?>

    <ul class="nav nav-tabs custom-tabs">
        <li role="presentation" class="tab-label active">
            <a href="#tab_basic_settings" data-toggle="tab">Základné nastavenia</a>
        </li>
        <li role="presentation" class="tab-label">
            <a href="#tab_variables_settings" data-toggle="tab">Premenné</a>
        </li>
    </ul>

    <div class="tab-content custom-tab-content">
        <div class="tab-pane fade in active" id="tab_basic_settings">

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'language_id')->dropDownList(
                ArrayHelper::map(Language::find()->all(), 'id', 'name')
            ) ?>

            <?= $form->field($model, 'domain')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'template_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Template::find()->all(), 'id', 'name'),
                'language' => 'en',
                'options' => ['placeholder' => 'Výber šablóny ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

            <?= $form->field($model, 'blog_main_page_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($model->pages, 'id',
                    'breadcrumbs'),
                'language' => 'en',
                'options' => ['placeholder' => 'Výber podstránky pre blog ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

            <?= $form->field($model, 'active')->widget(SwitchInput::classname(), [
                'type' => SwitchInput::CHECKBOX
            ]) ?>

            <?= $form->field($model, 'https_active')->widget(SwitchInput::classname(), [
                'type' => SwitchInput::CHECKBOX
            ]) ?>
        </div>
        <div class="tab-pane" id="tab_variables_settings">
            <?= VarManagerWidget::widget([
                'allVariables' => $allVariables,
                'assignedVariableValues' => $model->portalVarValues,
                'appendVarValueUrl' => Url::to(['portal/append-var-value']),
                'model' => $model
            ]) ?>
        </div>
    </div>

    <div class="navbar-fixed-bottom">
        <div class="col-sm-10 col-sm-offset-2">
            <div class="form-group">
                <?= Html::submitButton('Uložiť', [
                    'class' => 'btn btn-primary',
                    'id' => 'submit-btn'
                ]) ?>

                <?= Html::submitButton('Uložiť a pokračovať', [
                    'class' => 'btn btn-info',
                    'id' => 'submit-btn',
                    'name' => 'continue'
                ]) ?>

                <?= Html::a('Hard reset', Url::to(['hard-reset', 'id' => $model->id]), [
                    'class' => 'btn btn-danger',
                    'target' => '_blank'
                ]) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
