<?php
/* @var $model backend\models\Block */
use backend\models\Portal;
use backend\models\Snippet;
use backend\models\Tag;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;

/* @var $productType backend\models\ProductType */
/* @var $prefix string */

?>

<div class="col-md-12" id="appendSmartSnippetInfo">
    <?= BaseHtml::hiddenInput($prefix . "[parent_id]", $model->parent_id); ?>
    <div class="modal-header">
        <button type="button" class="btn modal close" data-dismiss="modal">
            <span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title snippet_edit_h4">
            <span title="Rozbaliť / zbaliť všetko" style="margin-right: 5px; cursor: pointer;">
                <i class="fa fa-sort"></i>
            </span>

            <?php if ($model->snippetCode) : ?>
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
            <?php else : ?>
                <?= Html::dropDownList('snippet_id', null, ArrayHelper::map(Snippet::find()->all(), 'id', 'name'), [
                    'prompt' => 'Výber snippetu',
                    'class' => 'snippet-dropdown',
                    'data-prefix' => $prefix,
                    'data-product-type-id' => $productType ? $productType->id : ''
                ]) ?>
            <?php endif; ?>
        </h4>
    </div>

    <div class="modal-body">
        <?php

        $globalObjects = array();

        $globalObjects['products'] = ArrayHelper::map(Portal::findOne(Yii::$app->session->get('portal_id'))->language->products,
            'id', 'name');

        $globalObjects['pages'] = ArrayHelper::map(Portal::findOne(Yii::$app->session->get('portal_id'))->pages, 'id',
            'breadcrumbs');

        $globalObjects['productTags'] = ArrayHelper::map(Tag::find()->all(), 'id', 'label');

        foreach ($model->snippetVarValues as $indexVar => $snippetVarValue) {
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


