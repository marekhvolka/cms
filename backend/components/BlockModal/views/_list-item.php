<?php
use backend\models\Block;
use yii\helpers\BaseHtml;

/* @var $listItem backend\models\ListItem */
/* @var $product backend\models\Product */
/* @var $prefix string */
/* @var $indexItem int */
/* @var $globalObjects array */
/* @var $parentId int */
?>

<div class="panel panel-collapsable panel-item list-item">
    <?= BaseHtml::hiddenInput($prefix . "[existing]", !$listItem->isNewRecord, ['class' => 'existing']); ?>
    <div class="panel-heading">
        <span>
            <i class="fa fa-bars"></i>
        </span>
        <span>
            <?= $listItem->order ?>
        </span>
        . položka
        <a class="btn btn-danger btn-xs pull-right btn-remove-list-item">
            <span class="glyphicon glyphicon-remove"></span>
        </a>
    </div>
    <div class="panel-body panel-collapse collapse in fixed-panel">
        <?php foreach ($listItem->snippetVarValues as $indexVar => $snippetVarValue) {
            echo $this->render('_snippet-var-value', [
                'snippetVarValue' => $snippetVarValue,
                'product' => $product,
                'prefix' => $prefix . "[SnippetVarValue][$indexVar]",
                'parentId' => $parentId
            ]);
        }
        ?>
    </div>
</div>
