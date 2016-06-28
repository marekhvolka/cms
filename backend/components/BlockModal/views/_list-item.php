<?php
use yii\helpers\BaseHtml;

/* @var $model backend\models\ListItem */
/* @var $productType backend\models\ProductType */
/* @var $prefix string */
/* @var $indexItem int */
/* @var $globalObjects array */
?>

<div class="panel panel-default list-item">
    <?= BaseHtml::hiddenInput($prefix . "[existing]", !$model->isNewRecord, ['class' => 'existing']); ?>
    <div class="panel-heading">
        <a data-toggle="collapse" href="#panelItem<?= $model->id ?>">
            <span>
                <i class="fa fa-angle-down"></i>
            </span>
        </a>
        <span>
            <i class="fa fa-bars"></i>
        </span>
        <span>
            <?= $model->order ?>
        </span>
        položka
        <a class="btn btn-danger btn-xs pull-right btn-remove-list-item">
            <span class="glyphicon glyphicon-remove"></span>
        </a>
    </div>
    <div class="panel-body panel-collapse collapse in" id="panelItem<?= $model->id ?>">
        <?php foreach ($model->snippetVarValues as $indexVar => $snippetVarValue) {
            echo $this->render('_snippet-var-value', [
                'model' => $snippetVarValue,
                'productType' => $productType,
                'prefix' => $prefix . "[SnippetVarValue][$indexVar]",
                'globalObjects' => $globalObjects
            ]);
        }
        ?>
    </div>
</div>