<?php
use backend\models\Portal;
use backend\models\Product;
use backend\models\ProductVar;
use backend\models\Snippet;
use backend\models\Tag;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;

/* @var $product Product */
/* @var $prefix string */
/* @var $productId int */
/* @var $model backend\models\Block */

?>

<div class="col-md-12">
    <?= BaseHtml::hiddenInput($prefix . "[parent_id]", $model->parent_id); ?>
    <div class="modal-header">
        <button type="button" class="btn modal close" data-dismiss="modal">
            <span aria-hidden="true">×</span>
            <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title snippet_edit_h4">
            <span title="Rozbaliť / zbaliť všetko" style="margin-right: 5px; cursor: pointer;">
                <i class="fa fa-sort"></i>
            </span>

            <?php switch ($model->type) {
                case 'snippet' :
                if ($model->snippetCode) : ?>
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
                        'data-product-id' => $product ? $product->id : ''
                    ]) ?>
                <?php endif;
                    break;

                case 'product_snippet' :
                    if (!$model->parent && $product) : ?>
                        <?= Html::activeDropDownList($model, 'parent_id',
                            ArrayHelper::map($product->productSnippets, 'id', 'varIdentifier'),
                            [
                                'name' => $prefix . '[parent_id]',
                                'class' => 'parent-dropdown',
                                'data-prefix' => $prefix,
                            ]) ?>
                <?php endif;
                    break;

                case 'portal_snippet' :
                    if (!$model->parent) : ?>
                        <?= Html::activeDropDownList($model, 'parent_id',
                            ArrayHelper::map(Portal::findOne(Yii::$app->session->get('portal_id'))->portalSnippets, 'id', 'varIdentifier'),
                            [
                                'name' => $prefix . '[parent_id]',
                                'class' => 'parent-dropdown',
                                'data-prefix' => $prefix,
                            ]) ?>

                    <?php endif;
                    break;
            } ?>
        </h4>
    </div>

    <div class="modal-body">
        <?php

        $globalObjects = array();

        $globalObjects['productVars'] = ArrayHelper::map(ProductVar::find()->all(), 'id', 'name');

        $globalObjects['products'] = ArrayHelper::map(Portal::findOne(Yii::$app->session->get('portal_id'))->language->products,
            'id', 'name');

        $globalObjects['pages'] = ArrayHelper::map(Portal::findOne(Yii::$app->session->get('portal_id'))->pages, 'id',
            'breadcrumbs');

        $globalObjects['productTags'] = ArrayHelper::map(Tag::find()->all(), 'id', 'label');

        foreach ($model->snippetVarValues as $indexVar => $snippetVarValue) {
            echo $this->render('_snippet-var-value', [
                'snippetVarValue' => $snippetVarValue,
                'product' => $product,
                'prefix' => $prefix . "[SnippetVarValue][$indexVar]",
                'globalObjects' => $globalObjects,
                'blockType' => $model->type
            ]);
        }
        ?>
    </div>
</div>


