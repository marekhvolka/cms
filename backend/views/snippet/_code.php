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

        <button type="button" class="btn-remove-snippet-code btn btn-danger btn-xs pull-right">
            <i class="glyphicon glyphicon-minus"></i>
        </button>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <?= CodemirrorWidget::widget([
                        'name' => $prefix . "[code]",
                        'value' => $model->code,
                        'assets' => [
                            CodemirrorAsset::MODE_CLIKE,
                            CodemirrorAsset::KEYMAP_EMACS,
                            CodemirrorAsset::ADDON_EDIT_MATCHBRACKETS,
                            CodemirrorAsset::ADDON_COMMENT,
                            CodemirrorAsset::ADDON_DIALOG,
                            CodemirrorAsset::ADDON_SEARCHCURSOR,
                            CodemirrorAsset::ADDON_SEARCH,
                            CodemirrorAsset::ADDON_DISPLAY_FULLSCREEN,
                            CodemirrorAsset::ADDON_DISPLAY_RULERS,
                            CodemirrorAsset::ADDON_FOLD_BRACE_FOLD
                        ],
                        'settings' => [
                            'lineNumbers' => true,
                            'mode' => 'text/x-csrc',
                        ],
                        'options' => [
                            'class' => 'html-editor form-control code-code attribute',
                            'data-attribute-name' => 'code',
                            'autofocus' => 'true',
                            'name' => $prefix . "[code]",
                            'rows' => 40
                        ]
                    ]
                ) ?>
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
        <?= BaseHtml::hiddenInput($prefix . "[existing]", $model->isNewRecord ? 'false' : 'true',
            ['class' => 'existing']); ?>
        <?= BaseHtml::hiddenInput($prefix . "[id]", $model->id); ?>
    </div>
</div>
