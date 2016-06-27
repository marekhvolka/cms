<?php

use backend\components\IdentifierGenerator\IdentifierGenerator;
use backend\components\LayoutWidget\LayoutWidget;
use yii\helpers\Html;
use yii\helpers\Url;
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
?>

<div class="page-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form',
        //'enableAjaxValidation' => true, //TODO: think about it :)
    ]); ?>

    <div class="panel panel-default">

        <div class="panel-heading">
            <h3>Základné nastavenia stránky</h3>
        </div>

        <div class="panel-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'identifier')->textInput(['maxlength' => true]) ?>

            <?= IdentifierGenerator::widget([
                'idTextFrom' => 'page-name',
                'idTextTo' => 'page-identifier',
                'delimiter' => '-',
            ]) ?>

            <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Portal::findOne(Yii::$app->session->get('portal_id'))->pages, 'id', 'name'),
                'language' => 'en',
                'options' => ['placeholder' => 'Výber rodiča ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

            <?= $form->field($model, 'active')->widget(SwitchInput::classname(), [
                'type' => SwitchInput::CHECKBOX
            ]) ?>

            <?= $form->field($model, 'in_menu')->widget(SwitchInput::classname(), [
                'type' => SwitchInput::CHECKBOX
            ]) ?>
        </div>
    </div>

    <?= $form->field($model, 'product_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Portal::findOne(Yii::$app->session->get('portal_id'))->language->products, 'id',
            'name'),
        'language' => 'en',
        'options' => ['placeholder' => 'Výber produktu ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>SEO nastavenia</h3>
        </div>

        <div class="panel-body">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea() ?>

            <?= $form->field($model, 'keywords')->textarea() ?>
        </div>
    </div>

    <?= $form->field($model, 'color_scheme')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'header_active')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX,
        'pluginOptions' => [
            'onText' => 'Aktívny',
            'offText' => 'Neaktívny',
        ]
    ]) ?>

    <h3 class="page-header">Hlavička stránky</h3>

    <?= LayoutWidget::widget([
            'sections' => $model->headerSections,
            'prefix' => 'headerSection',
            'type' => 'header',
            'controllerUrl' => Url::to(['/page'])
        ]
    ) ?>

    <h3 class="page-header">Hlavný obsah</h3>

    <?= LayoutWidget::widget([
            'sections' => $model->contentSections,
            'type' => 'content',
            'prefix' => 'contentSection',
            'controllerUrl' => Url::to(['/page']),
            'allowAddingSection' => false
        ]
    ) ?>

    <h3 class="page-header">Sidebar</h3>

    <?= $form->field($model, 'sidebar_active')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX,
        'pluginOptions' => [
            'onText' => 'Aktívny',
            'offText' => 'Neaktívny',
        ]
    ]) ?>

    <?= $form->field($model, 'sidebar_side')->radioList([
        'left' => 'Vľavo',
        'right' => 'Vpravo',
    ]) ?>

    <?= $form->field($model, 'sidebar_size')->radioList([
        '4' => '8:4',
        '5' => '7:5',
        '6' => '6:6',
        '7' => '5:7',
        '8' => '4:8',
    ]) ?>

    <?= LayoutWidget::widget([
            'sections' => $model->sidebarSections,
            'type' => 'sidebar',
            'prefix' => 'sidebarSection',
            'controllerUrl' => Url::to(['/page']),
            'allowAddingSection' => false
        ]
    ) ?>

    <h3 class="page-header">Patička stránky</h3>

    <?= $form->field($model, 'footer_active')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <?= LayoutWidget::widget([
            'sections' => $model->footerSections,
            'prefix' => 'footerSection',
            'type' => 'footer',
            'controllerUrl' => Url::to(['/page'])
        ]
    ) ?>

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

    <div class="modal fade" id="blockModal" tabindex="-1" role="dialog" aria-labelledby="uploadFileModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>
</div>