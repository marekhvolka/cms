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

<div class="item panel panel-default snippet-code"><!-- widgetBody -->
    <div class="panel-heading"> 
        <div class="input-group">
            <?= BaseHtml::activeTextInput($snippetCode, "name", [
                    'class' => 'form-control',
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
                echo BaseHtml::activeTextarea($snippetCode, "code", [
                    'class' => 'form-control',
                    'name' => "SnippetCode[$postIndex][code]",
                ]);
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
                    'class' => 'form-control',
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
                $data = ArrayHelper::map(Portal::find()->all(), 'id', 'name');
                echo BaseHtml::activeDropDownList($snippetCode, "portal", $data, [
                    'maxlength' => true, 
                    'class' => 'form-control',
                    'name' => "SnippetCode[$postIndex][portal]",
                ]);
                ?>
            </div>
        </div>
        
        <?= BaseHtml::hiddenInput("SnippetCode[$postIndex][id]", $snippetCode->id); ?>
    </div>
</div>
