<?php

use backend\components\IdentifierGenerator\IdentifierGenerator;
use backend\components\LayoutWidget\LayoutWidget;
use backend\models\PostCategory;
use backend\models\PostTag;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

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
                'idTextFrom' => 'post-name',
                'idTextTo' => 'post-identifier',
                'delimiter' => '-',
            ]) ?>

            <?= $form->field($model, 'published_at')->widget(DatePicker::className(), [
                'dateFormat' => 'yyyy/MM/dd',
                'class' => 'form-control'
            ]) ?>

            <?= $form->field($model, 'post_category_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(PostCategory::find()->all(), 'id', 'name'),
                'language' => 'en',
                'options' => ['placeholder' => 'Výber kategórie ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

            <?= $form->field($model, 'perex')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'active')->widget(SwitchInput::classname(), [
                'type' => SwitchInput::CHECKBOX
            ]) ?>
        </div>

        <div class="tab-pane" id="tab_tags_settings">
            <div class="form-group">
                <label class="control-label" for="snippetcode-portal">
                    Tagy pre článok
                </label>
                <?= Select2::widget([
                    'name' => '[tags]',
                    'value' => array_map(function ($item) {
                        return $item->id;
                    }, $model->tags),
                    'data' => ArrayHelper::map(PostTag::find()->all(), 'id', 'name'),
                    'options' => [
                        'placeholder' => 'Priradiť tagy',
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                    ],
                ]) ?>
            </div>
        </div>
        <div class="tab-pane" id="tab_layout_settings">

            <h3 class="page-header">Hlavička stránky</h3>

            <?= $form->field($model->header, 'active')->radioList([
                '0' => 'Neaktívna',
                '1' => 'Aktívna',
            ], [
                'name' => 'header[active]'
            ]) ?>

            <?= LayoutWidget::widget([
                    'area' => $model->header,
                    'controllerUrl' => Url::to(['/post']),
                    'page' => $model,
                    'portal' => null
                ]
            ) ?>

            <h3 class="page-header">Hlavný obsah</h3>

            <?= LayoutWidget::widget([
                    'area' => $model->content,
                    'controllerUrl' => Url::to(['/post']),
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
                    'controllerUrl' => Url::to(['/post']),
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
                    'controllerUrl' => Url::to(['/post']),
                    'page' => $model,
                    'portal' => null
                ]
            ) ?>
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

</div>
