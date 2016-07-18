<?php

use backend\components\IdentifierGenerator\IdentifierGenerator;
use backend\components\LayoutWidget\LayoutWidget;
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
if ($model->portal) {
    $portal = $model->portal;
} else {
    $portal = Yii::$app->user->identity->portal;
}
?>

<div class="page-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form',
        'enableAjaxValidation' => true,
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
                'data' => ArrayHelper::map($portal->pages, 'id', 'breadcrumbs'),
                'language' => 'en',
                'options' => ['placeholder' => 'Výber rodiča ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

            <?= $form->field($model, 'active')->widget(SwitchInput::classname(), [
                'type' => SwitchInput::CHECKBOX
            ]) ?>
        </div>
    </div>

    <?= $form->field($model, 'product_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map($portal->language->products, 'id',
            'breadcrumbs'),
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

    <?= $form->field($model, 'color_scheme')->dropDownList(
        ArrayHelper::map($portal->template->getColorSchemes(), 'label',
            'label')); ?>

    <h3 class="page-header">Hlavička stránky</h3>

    <?= $form->field($model->header, 'active')->radioList([
        '0' => 'Neaktívna',
        '1' => 'Aktívna',
    ], [
        'name' => 'header[active]'
    ]) ?>

    <?= LayoutWidget::widget([
            'area' => $model->header,
            'controllerUrl' => Url::to(['/page']),
            'page' => $model,
            'portal' => null
        ]
    ) ?>

    <h3 class="page-header">Hlavný obsah</h3>

    <?= LayoutWidget::widget([
            'area' => $model->content,
            'controllerUrl' => Url::to(['/page']),
            'allowAddingSection' => false,
            'page' => $model,
            'portal' => null
        ]
    ) ?>

    <h3 class="page-header">Sidebar</h3>

    <?= $form->field($model->sidebar, 'active')->radioList([
        '0' => 'Neaktívny',
        '1' => 'Aktívny',
    ], [
        'name' => 'sidebar[active]'
    ]) ?>


    <?= $form->field($model, 'sidebar_side')->radioList([
        'left' => 'Vľavo',
        'right' => 'Vpravo',
    ]) ?>

    <?= $form->field($model->sidebar, 'size')->radioList([
        '4' => '8:4',
        '5' => '7:5',
        '6' => '6:6',
        '7' => '5:7',
        '8' => '4:8',
    ], [
        'name' => 'sidebar[size]'
    ]) ?>

    <?= LayoutWidget::widget([
            'area' => $model->sidebar,
            'controllerUrl' => Url::to(['/page']),
            'allowAddingSection' => false,
            'page' => $model,
            'portal' => null
        ]
    ) ?>

    <h3 class="page-footer">Patička stránky</h3>

    <?= $form->field($model->footer, 'active')->radioList([
        '0' => 'Neaktívna',
        '1' => 'Aktívna',
    ], [
        'name' => 'footer[active]'
    ]) ?>

    <?= LayoutWidget::widget([
            'area' => $model->footer,
            'controllerUrl' => Url::to(['/page']),
            'page' => $model,
            'portal' => null
        ]
    ) ?>

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
                <?= Html::a('Náhľad', Url::to(['show', 'id' => $model->id]), [
                    'class' => 'btn btn-info',
                    'target' => '_blank'
                ]) ?>
                <?= Html::a('Hard reset a náhľad', Url::to(['hard-reset', 'id' => $model->id]), [
                    'class' => 'btn btn-danger',
                    'target' => '_blank'
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