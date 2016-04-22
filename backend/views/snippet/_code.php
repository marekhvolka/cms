<?php 

use yii\helpers\Html;
use conquer\codemirror\CodemirrorAsset;
use conquer\codemirror\CodemirrorWidget;

?>

<div class="item panel panel-default"><!-- widgetBody -->
    <button type="button" class="remove-item btn btn-danger btn-xs">
        <i class="glyphicon glyphicon-minus"></i>
    </button>

    <div class="panel-heading"> 
        <div class="input-group">
            <?= $form->field($modelSnippetCode, "[{$i}]name")->textInput(['maxlength' => true]) ?>
            <div class="pull-right">
                <button type="button" class="add-item btn btn-success btn-xs">
                    <i class="glyphicon glyphicon-plus"></i>
                </button>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="panel-body">
        <?php
        // necessary for update action.
        if (!$modelSnippetCode->isNewRecord) {
            echo Html::activeHiddenInput($modelSnippetCode, "[{$i}]id");
        }
        ?>

        <div class="row">
            <div class="col-sm-12">
                <?php
                echo $form->field($modelSnippetCode, "[{$i}]code")->widget(
                        CodemirrorWidget::className(), [
                    'assets' => [
                        CodemirrorAsset::MODE_CLIKE,
                        CodemirrorAsset::KEYMAP_EMACS,
                        CodemirrorAsset::ADDON_EDIT_MATCHBRACKETS,
                        CodemirrorAsset::ADDON_COMMENT,
                        CodemirrorAsset::ADDON_DIALOG,
                        CodemirrorAsset::ADDON_SEARCHCURSOR,
                        CodemirrorAsset::ADDON_SEARCH,
                    ],
                    'settings' => [
                        'lineNumbers' => true,
                        'mode' => 'text/x-csrc',
                    ],
                    'options' => [
                        'class' => 'html-editor'
                    ]
                        ]
                );
                ?>
            </div>
        </div><!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($modelSnippetCode, "[{$i}]popis")->textarea(['rows' => '4']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($modelSnippetCode, "[{$i}]portal")->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
</div>
