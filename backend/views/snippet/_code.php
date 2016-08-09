<?php

use backend\models\Portal;
use backend\components\AceEditor\AceEditorWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;

/* @var $this yii\web\View */
/* @var $model backend\models\SnippetCode */
/* @var $form yii\widgets\ActiveForm */
/* @var $indexCode int */
/* @var $prefix string */

?>

<div class="item panel panel-default snippet-code"><!-- widgetBody -->
    <a class="anchor" id="code<?= $model->id ?>" name="code<?= $model->id ?>"></a>
    <div class="panel-heading form-inline">

        <?= BaseHtml::activeTextInput($model, "name", [
            'class' => 'form-control snippetcode-name',
            'name' => $prefix . "[name]",
        ]); ?>

        <?= \kartik\switchinput\SwitchInput::widget([
            'type' => \kartik\switchinput\SwitchInput::CHECKBOX,
            'name' => $prefix . "[dynamic]",
            'value' => $model->dynamic,
            'id' => hash('md5', $prefix),
            'class' => 'form-control ',
            'pluginOptions' => [
                'onText' => 'Dynamický',
                'offText' => 'Statický',
                ]
        ]) ?>

        <button type="button" class="btn-remove-snippet-code btn btn-danger btn-xs pull-right">
            <i class="glyphicon glyphicon-minus"></i>
        </button>
        <button type="button" class="btn-alternative-usage btn btn-primary btn-xs pull-right">
            <i class="glyphicon glyphicon-question-sign"></i>
        </button>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <?= AceEditorWidget::widget([
                    'name' => $prefix . '[code]',
                    'value' => $model->code,
                    'varNameAceEditor' => 'code' . hash('md5', $prefix),
                    'theme' => 'chrome',
                    'aceOptions' => [
                        'showPrintMargin' => false,
                        "maxLines" => 29,
                        "minLines" => 5,
                    ]
                ]); ?>
            </div>
        </div><!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <label class="control-label" for="snippetcode-popis">
                    <?= $model->getAttributeLabel('description'); ?>
                </label>
                <?php
                echo BaseHtml::activeTextarea($model, "description", [
                    'class' => 'form-control',
                    'name' => $prefix . "[description]",
                ]);
                ?>
            </div>
        </div>
        <?= $this->render('_blocks-and-sections', [
            'model' => $model,
            'prefix' => $prefix
        ]); ?>
        <?= BaseHtml::hiddenInput($prefix . "[existing]", $model->isNewRecord ? 'false' : 'true',
            ['class' => 'existing']); ?>
        <?= BaseHtml::hiddenInput($prefix . "[id]", $model->id, ['class' => 'snippet-code-id']); ?>
    </div>
</div>
