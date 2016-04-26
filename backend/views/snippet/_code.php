<?php 

use yii\helpers\Html;
use conquer\codemirror\CodemirrorAsset;
use conquer\codemirror\CodemirrorWidget;
use yii\helpers\BaseHtml;

?>
<?php
$arrayFirstDymensionValue = $snippetCode->id ? : 'placeholder';
?>

<div class="item panel panel-default panel-codes"><!-- widgetBody -->
    
    
    <button type="button" class="remove-item-code btn btn-danger btn-xs">
        <i class="glyphicon glyphicon-minus"></i>
    </button>
    
    <button type="button" class="add-item-code btn btn-success btn-xs">
        <i class="glyphicon glyphicon-plus"></i>
    </button>
     

    <div class="panel-heading"> 
        <div class="input-group">
            <label class="control-label" for="snippetcode-name">
                <?= $snippetCode->getAttributeLabel('name'); ?>
            </label>
            <?= BaseHtml::activeTextInput($snippetCode, "name", [ 
                    'class' => 'form-control code-name attribute',
                    'data-attribute-name' => 'name',
                    'name' => "SnippetCode[$arrayFirstDymensionValue][name]",
                ]); ?>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <label class="control-label" for="snippetcode-code">
                    <?= $snippetCode->getAttributeLabel('code'); ?>
                </label>
                <?php
                echo CodemirrorWidget::widget([
                        'name' => "SnippetCode[$arrayFirstDymensionValue][code]",
                        'value' => $snippetCode->code,
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
                            'class' => 'html-editor form-control code-code attribute',
                            'data-attribute-name' => 'code',
                            'autofocus' => 'false',
                            'name' => "SnippetCode[$arrayFirstDymensionValue][code]",
                        ]
                    ]
                );
                ?>
            </div>
        </div><!-- .row -->
        <div class="row">
            <div class="col-sm-12">                
                <label class="control-label" for="snippetcode-popis">
                    <?= $snippetCode->getAttributeLabel('popis'); ?>
                </label>
                <?php
                echo BaseHtml::activeTextarea($snippetCode, "popis", [ 
                    'class' => 'form-control code-popis attribute',
                    'data-attribute-name' => 'popis',
                    'name' => "SnippetCode[$arrayFirstDymensionValue][popis]",
                ]);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label class="control-label" for="snippetcode-portal">
                    <?= $snippetCode->getAttributeLabel('portal'); ?>
                </label>
                <?php
                echo BaseHtml::activeTextInput($snippetCode, "portal", [
                    'maxlength' => true, 
                    'class' => 'form-control code-portal attribute',
                    'data-attribute-name' => 'portal',
                    'name' => "SnippetCode[$arrayFirstDymensionValue][portal]",
                ]);
                ?>
            </div>
        </div>
        
        <?= BaseHtml::hiddenInput("SnippetCode[$arrayFirstDymensionValue][id]", $snippetCode->id, [
            'class' => 'code-id attribute',
            'data-attribute-name' => 'id',
            ]); ?>
    </div>
</div>
