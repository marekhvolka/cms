<?php

use backend\components\IdentifierGenerator\IdentifierGenerator;
use backend\components\LayoutWidget\LayoutWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Page;
use backend\models\Product;
use backend\models\Portal;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Page */
/* @var $form yii\widgets\ActiveForm */
/* @var $headerSections \backend\models\Section */
/* @var $footerSections \backend\models\Section */
/* @var $contentSections \backend\models\Section */
/* @var $sidebarSections \backend\models\Section */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'identifier')->textInput(['maxlength' => true]) ?>

    <?=IdentifierGenerator::widget([
        'idTextFrom' => 'page-name',
        'idTextTo' => 'page-identifier',
        'delimiter' => '-',
    ])?>

    <?= $form->field($model, 'active')->widget(SwitchInput::classname(), [
    'type' => SwitchInput::CHECKBOX
    ]) ?>

    <?= $form->field($model, 'in_menu')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Page::find()->all(), 'id', 'name'),
        'language' => 'en',
        'options' => ['placeholder' => 'Výber rodiča ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'product_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Product::find()->all(), 'id', 'name'),
        'language' => 'en',
        'options' => ['placeholder' => 'Výber produktu ...'],
        'pluginOptions' => [
        'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea() ?>

    <?= $form->field($model, 'keywords')->textarea() ?>

    <?= $form->field($model, 'color_scheme')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'footer_active')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <?= $form->field($model, 'header_active')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <h3 class="page-header">Hlavička stránky</h3>

    <?= LayoutWidget::widget([
            'sections' => $headerSections
        ]
    )?>

    <h3 class="page-header">Hlavný obsah</h3>

    <?= LayoutWidget::widget([
            'sections' => $contentSections
        ]
    )?>

    <h3 class="page-header">Sidebar</h3>

    <?= $form->field($model, 'sidebar_active')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <?= $form->field($model, 'sidebar_side')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sidebar_size')->textInput() ?>

    <?= LayoutWidget::widget([
            'sections' => $sidebarSections
        ]
    )?>

    <h3 class="page-header">Patička stránky</h3>

    <?= LayoutWidget::widget([
            'sections' => $footerSections
        ]
    )?>

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

</div>
