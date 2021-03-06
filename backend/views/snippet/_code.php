<?php

use backend\models\Portal;
use backend\components\AceEditor\AceEditorWidget;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SnippetCode */
/* @var $form yii\widgets\ActiveForm */
/* @var $indexCode int */
/* @var $prefix string */

?>

<div class="item panel panel-default snippet-code"><!-- widgetBody -->
    <a class="anchor" id="code<?= $model->id ?>" name="code<?= $model->id ?>"></a>
    <div class="panel-heading form-inline">
        <?= Html::hiddenInput($prefix . "[removed]", $model->removed, ['class' => 'removed']); ?>
        <?= Html::hiddenInput($prefix . "[id]", $model->id, ['class' => 'snippet-code-id']); ?>

        <?= Html::textInput($prefix . "[name]", $model->name, ['class' => 'form-control snippetcode-name']); ?>

        <?= Html::checkbox($prefix . '[dynamic]', $model->dynamic, [
            'data-check' => 'switch',
            'data-on-color' => 'success',
            'data-on-text' => 'Dynamický',
            'data-off-color' => 'default',
            'data-off-text' => 'Statický',
            'value' => 1,
            'uncheck' => 0
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
                <?= Html::textarea($prefix . "[description]", $model->description, ['class' => 'form-control']) ?>
            </div>
        </div>
        <?= $this->render('_blocks-and-sections', [
            'model' => $model,
            'prefix' => $prefix
        ]); ?>
    </div>
</div>
