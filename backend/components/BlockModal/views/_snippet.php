<?php
/* @var $model backend\models\Block */
use kartik\select2\Select2;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

/* @var $productType backend\models\ProductType */
/* @var $prefix string */

?>

<div class="col-md-12" id="appendSmartSnippetInfo">
    <div class="modal-header">
        <button type="button" class="btn modal close" data-dismiss="modal">
            <span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title snippet_edit_h4">
            <span title="Rozbaliť / zbaliť všetko" style="margin-right: 5px; cursor: pointer;">
                <i class="fa fa-sort"></i>
            </span>
            <span id=""><?= $model->snippetCode->snippet->name ?></span>

            <?= Html::activeDropDownList($model, 'snippet_code_id',
                ArrayHelper::map($model->snippetCode->snippet->snippetCodes, 'id', 'name'),
                [
                    'name' => $prefix . '[snippet_code_id]'
                ]) ?>

            <button type="button" class="btn btn-warning btn-xs btn-remove-var pull-right"
                    style="right: 60px; top: 13px;" data-toggle="modal"
                    data-target="#supportModal" title="Nápoveda">
                <span class="fa fa-question"></span>
            </button>
        </h4>
    </div>

    <div class="modal-body">
        <?php
        foreach ($model->snippetVarValues as $indexVar => $snippetVarValue) {
            echo $this->render('_snippet-var-value', [
                'model' => $snippetVarValue,
                'productType' => $productType,
                'prefix' => $prefix . "[snippetVarValue][$indexVar]"
            ]);
        }
        ?>
    </div>
</div>


