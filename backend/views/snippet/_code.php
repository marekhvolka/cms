<?php

use backend\models\Portal;
use conquer\codemirror\CodemirrorAsset;
use conquer\codemirror\CodemirrorWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;

/* @var $this yii\web\View */
/* @var $model backend\models\SnippetCode */
/* @var $form yii\widgets\ActiveForm */
/* @var $indexCode int */
/* @var $prefix string */

?>

<div class="item panel panel-default snippet-code"><!-- widgetBody -->
    <a class="anchor" id="code<?= $model->id ?>"></a>
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
                <?= trntv\aceeditor\AceEditor::widget([
                    // You can either use it for model attribute
                    'model' => $model,
                    'attribute' => 'code',

                    'mode' => 'php', // programing language mode. Default "html"
                    'theme' => 'chrome', // editor theme. Default "github"
                    'options' => [
                        'name' => $prefix . "[code]",
                        'value' => $model->code,
                        'id' => 'code' . hash('md5', $prefix)
                    ]
                ])
                ?>
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
        <div class="row">
            <div class="col-sm-12">
                <label class="control-label" for="snippetcode-portal">
                    <?= $model->getAttributeLabel('portal'); ?>
                </label>

                <?php
                $data = ArrayHelper::map(Portal::find()->all(), 'id', 'name');
                echo BaseHtml::activeDropDownList($model, "portal", $data, [
                    'maxlength' => true,
                    'class' => 'form-control',
                    'name' => $prefix . "[portal]",
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
