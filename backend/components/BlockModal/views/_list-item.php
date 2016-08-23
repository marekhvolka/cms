<?php
use backend\models\Block;
use backend\models\Portal;
use yii\helpers\Html;

/* @var $listItem backend\models\ListItem */
/* @var $page backend\models\Page */
/* @var $portal Portal */
/* @var $prefix string */
/* @var $indexItem int */
/* @var $globalObjects array */
/* @var $parentId int */
?>

<div class="panel panel-collapsable panel-item list-item">
    <?= Html::hiddenInput($prefix . "[removed]", $listItem->removed, ['class' => 'removed']); ?>
    <div class="panel-heading">
        <span>
            <i class="glyphicon glyphicon-chevron-up collapse-btn"></i>
        </span>
        <span class="">
            <i class="fa fa-bars list-item-drag-by"></i>
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
                'page' => $page,
                'portal' => $portal,
                'prefix' => $prefix . "[SnippetVarValue][$indexVar]",
                'parentId' => $parentId
            ]);
        }
        ?>
    </div>
</div>
