<?php 

use yii\helpers\Html;
use conquer\codemirror\CodemirrorAsset;
use conquer\codemirror\CodemirrorWidget;
use yii\helpers\BaseHtml;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\Portal;

?>
<?php
$postIndex = rand(0, 10000000); // Index for correctly indexing Post request variable.
?>

<li class="item panel panel-default panel-codes" id="code<?php echo $snippetCode->id; ?>"><!-- widgetBody -->
    <div class="panel-heading"> 
        <div class="input-group">
            <?= BaseHtml::activeTextInput($snippetCode, "name", [
                    'class' => 'form-control code-name attribute',
                    'data-attribute-name' => 'name',
                    'name' => "SnippetCode[$postIndex][name]",
                    'style'=>'width:400px'
                ]); ?>
        </div>
        <button type="button" class="add-item-code btn btn-success btn-xs pull-right">
            <i class="glyphicon glyphicon-plus"></i>
        </button>

        <button type="button" class="remove-item-code btn btn-danger btn-xs pull-right">
            <i class="glyphicon glyphicon-minus"></i>
        </button>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <label class="control-label" for="snippetcode-code">
                    <?= $snippetCode->getAttributeLabel('code'); ?>
                </label>
                <?php
                echo CodemirrorWidget::widget([
                        'name' => "SnippetCode[$postIndex][code]",
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
                            'name' => "SnippetCode[$postIndex][code]",
                        ]
                    ]
                );
                ?>
            </div>
        </div><!-- .row -->
        <div class="row">
            <div class="col-sm-12">                
                <label class="control-label" for="snippetcode-popis">
                    <?= $snippetCode->getAttributeLabel('description'); ?>
                </label>
                <?php
                echo BaseHtml::activeTextarea($snippetCode, "description", [
                    'class' => 'form-control code-popis attribute',
                    'data-attribute-name' => 'popis',
                    'name' => "SnippetCode[$postIndex][description]",
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
                echo BaseHtml::activeDropDownList($snippetCode, "portal", $data, [
                    'maxlength' => true, 
                    'class' => 'form-control code-portal attribute',
                    'data-attribute-name' => 'portal',
                    'name' => "SnippetCode[$postIndex][portal]",
                ]);
                ?>
            </div>
        </div>
        
        <?= BaseHtml::hiddenInput("SnippetCode[$postIndex][id]", $snippetCode->id, [
            'class' => 'code-id attribute',
            'data-attribute-name' => 'id',
            ]); ?>
    </div>
</li>

<?php

$js = <<<JS

// Remove button clicked - code must be removed.
$('.remove-item-code').bind('click', function() {
    $(this).parent().remove();
});     
        
JS;
$this->registerJs($js);
?>


