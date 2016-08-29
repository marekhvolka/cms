<?php

use backend\components\IdentifierGenerator\IdentifierGenerator;
use backend\components\LayoutWidget\LayoutWidget;
use backend\components\MultipleSwitch\MultipleSwitchWidget;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Page */
/* @var $form yii\widgets\ActiveForm */

?>

<?php
/*
$this->registerJs(
    '$("document").ready(function(){ 
        $("#page_form").on("pjax:end", function() {
            $.pjax.reload({container:"#page_form"});  //Reload GridView
        });
    });'
);*/
?>

<?php
if ($model->portal) {
    $portal = $model->portal;
} else {
    $portal = Yii::$app->user->identity->portal;
}
?>

<div class="page-form">
    <?php /*Pjax::begin(['id' => 'page_form']);*/ ?>

    <?php $form = ActiveForm::begin([
        'id' => 'form',
        'enableAjaxValidation' => true,
        //'options' => ['data-pjax' => true]
    ]); ?>

    <ul class="nav nav-tabs" id="myTab">
        <li role="presentation" class="tab-label active">
            <a href="#tab_basic_settings" data-toggle="tab">Základné nastavenia</a>
        </li>
        <li role="presentation" class="tab-label">
            <a href="#tab_seo_settings" data-toggle="tab">SEO nastavenia</a>
        </li>
        <li role="presentation" class="tab-label">
            <a href="#tab_layout_settings" data-toggle="tab">Layout</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade in active" id="tab_basic_settings">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'identifier')->textInput(['maxlength' => true]) ?>

            <?= IdentifierGenerator::widget([
                'idTextFrom' => 'page-name',
                'idTextTo' => 'page-identifier',
                'delimiter' => '-',
            ]) ?>

            <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($portal->pages, 'id', 'breadcrumbs'),
                'language' => 'en',
                'options' => ['placeholder' => 'Výber rodiča ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

            <?= $form->field($model, 'product_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($portal->language->products, 'id',
                    'breadcrumbs'),
                'language' => 'en',
                'options' => ['placeholder' => 'Výber produktu ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

            <?= $form->field($model, 'active')->widget(SwitchInput::classname(), [
                'type' => SwitchInput::CHECKBOX
            ]) ?>
        </div>
        <div class="tab-pane" id="tab_seo_settings">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea() ?>

            <?= $form->field($model, 'keywords')->textarea() ?>
        </div>
        <div class="tab-pane" id="tab_layout_settings">
            <h3 class="page-header">Hlavička stránky</h3>

            <?= Html::checkbox('header[active]', $model->header->active, [
                'data-check' => 'switch',
                'data-on-color' => 'primary',
                'data-on-text' => 'Aktívny',
                'data-off-color' => 'default',
                'data-off-text' => 'Neaktívny',
                'value' => 1,
                'uncheck' => 0
            ]) ?>

            <?= LayoutWidget::widget([
                    'area' => $model->header,
                    'controllerUrl' => Url::to(['/page']),
                    'layoutOwner' => $model,
                    'portal' => null
                ]
            ) ?>

            <h3 class="page-header">Hlavný obsah</h3>

            <?= LayoutWidget::widget([
                    'area' => $model->content,
                    'controllerUrl' => Url::to(['/page']),
                    'allowAddingSection' => false,
                    'layoutOwner' => $model,
                    'portal' => null
                ]
            ) ?>

            <h3 class="page-header">Sidebar</h3>

            <?= Html::checkbox('sidebar[active]', $model->sidebar->active, [
                'data-check' => 'switch',
                'data-on-color' => 'primary',
                'data-on-text' => 'Aktívny',
                'data-off-color' => 'default',
                'data-off-text' => 'Neaktívny',
                'value' => 1,
                'uncheck' => 0
            ]) ?>

            <?= Html::checkbox('sidebar_side', $model->sidebar_side, [
                'data-check' => 'switch',
                'data-on-color' => 'default',
                'data-on-text' => 'Vpravo',
                'data-off-color' => 'default',
                'data-off-text' => 'Vľavo',
                'value' => 'right',
                'uncheck' => 'left'
            ]) ?>

            <?= MultipleSwitchWidget::widget([
                'name' => 'sidebar[size]',
                'items' => [
                    '4' => '8:4',
                    '5' => '7:5',
                    '6' => '6:6',
                    '7' => '5:7',
                    '8' => '4:8',
                ],
                'value' => $model->sidebar->size
            ]) ?>

            <?= LayoutWidget::widget([
                    'area' => $model->sidebar,
                    'controllerUrl' => Url::to(['/page']),
                    'allowAddingSection' => false,
                    'layoutOwner' => $model,
                    'portal' => null
                ]
            ) ?>

            <h3 class="page-footer">Patička stránky</h3>

            <?= Html::checkbox('footer[active]', $model->footer->active, [
                'data-check' => 'switch',
                'data-on-color' => 'primary',
                'data-on-text' => 'Aktívny',
                'data-off-color' => 'default',
                'data-off-text' => 'Neaktívny',
                'value' => 1,
                'uncheck' => 0
            ]) ?>

            <?= LayoutWidget::widget([
                    'area' => $model->footer,
                    'controllerUrl' => Url::to(['/page']),
                    'layoutOwner' => $model,
                    'portal' => null
                ]
            ) ?>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="navbar-fixed-bottom">
        <div class="col-sm-10 col-sm-offset-2">
            <div class="form-group">
                <?= Html::submitButton('Uložiť', [
                    'class' => 'btn btn-primary',
                    'id' => 'submit-btn',
                    'data' => [
                        'pjax' => false
                    ]
                ]) ?>

                <?= Html::submitButton('Uložiť a pokračovať', [
                    'class' => 'btn btn-info',
                    'id' => 'submit-btn',
                    'name' => 'continue'
                ]) ?>
                <?= Html::a('Náhľad', Url::to(['show', 'id' => $model->id]), [
                    'class' => 'btn btn-info',
                    'target' => '_blank',
                    'data' => [
                        'pjax' => false
                    ]
                ]) ?>
                <?= Html::a('Hard reset a náhľad', Url::to(['hard-reset', 'id' => $model->id]), [
                    'class' => 'btn btn-danger',
                    'target' => '_blank',
                    'data' => [
                        'pjax' => false
                    ]
                ]) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?php /*Pjax::end();*/ ?>

    <div class="modal fade" id="blockModal" tabindex="-1" role="dialog" aria-labelledby="uploadFileModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>
</div>