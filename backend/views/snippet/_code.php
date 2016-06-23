<?php

use conquer\codemirror\CodemirrorAsset;
use conquer\codemirror\CodemirrorWidget;
use yii\helpers\BaseHtml;
use yii\helpers\ArrayHelper;
use backend\models\Portal;

/* @var $this yii\web\View */
/* @var $model backend\models\SnippetCode */
/* @var $form yii\widgets\ActiveForm */

?>
<?php

if (!isset($indexCode))
    $indexCode = rand(1000, 10000000); // Index for correctly indexing Post request variable.
?>

<div class="item panel panel-default snippet-code"><!-- widgetBody -->
    <a class="anchor" id="code<?= $model->id?>"></a>
    <div class="panel-heading"> 
        <div class="input-group">
            <?= BaseHtml::activeTextInput($model, "name", [
                    'class' => 'form-control snippetcode-name',
                    'name' => "SnippetCode[$indexCode][name]",
                    'id' => "snippetcode-$indexCode-name",
                ]); ?>
            <div class="help-block"></div>
        </div>
        <button type="button" class="btn-add-snippet-code btn btn-success btn-xs pull-right">
            <i class="glyphicon glyphicon-plus"></i>
        </button>

        <button type="button" class="btn-remove-snippet-code btn btn-danger btn-xs pull-right">
            <i class="glyphicon glyphicon-minus"></i>
        </button>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <?php
                echo CodemirrorWidget::widget([
                        'name' => "SnippetCode[$indexCode][code]",
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
                            'name' => "SnippetCode[$indexCode][code]",
                            'rows' => 40
                        ]
                    ]
                );
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
                    'name' => "SnippetCode[$indexCode][description]",
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
                    'name' => "SnippetCode[$indexCode][portal]",
                ]);
                ?>
            </div>
        </div>
        <?= BaseHtml::hiddenInput("SnippetCode[$indexCode][existing]", $model->isNewRecord ? 'false' : 'true', ['class' => 'existing']); ?>
        <?= BaseHtml::hiddenInput("SnippetCode[$indexCode][id]", $model->id); ?>
    </div>
</div>
