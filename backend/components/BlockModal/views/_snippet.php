<?php
use backend\controllers\BaseController;
use backend\models\Portal;
use backend\models\Product;
use backend\models\Snippet;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;
use yii\helpers\Url;

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
        <span class="modal-title snippet_edit_h4">
            <span title="Rozbaliť / zbaliť všetko" style="margin-right: 5px; cursor: pointer;">
                <i class="fa fa-sort"></i>
            </span>

            <?php switch ($model->type) {
            case 'snippet' :
            if ($model->snippetCode) : ?>
                <span><?= $model->snippetCode->snippet->name ?></span>

                        <?= Html::activeDropDownList($model, 'snippet_code_id',
                ArrayHelper::map($model->snippetCode->snippet->snippetCodes, 'id', 'name'),
                [
                    'name' => $prefix . '[snippet_code_id]',
                    'class' => 'change-snippet-code not-applied'
                ]) ?>



                <button type="button" class="btn btn-warning btn-xs btn-remove-var pull-right"
                        style="right: 60px; top: 13px;" data-toggle="modal"
                        data-target="#supportModal" title="Nápoveda">
                            <span class="fa fa-question"></span>
                        </button>
                    <?php else : ?>
                        <?= Html::dropDownList('snippet_id', null,
                    ArrayHelper::map(Snippet::find()->all(), 'id', 'name'), [
                        'prompt' => 'Výber snippetu',
                        'class' => 'snippet-dropdown',
                        'data-type' => $model->type,
                        'data-prefix' => $prefix,
                        'data-product-id' => $product ? $product->id : ''
                    ]) ?>


                <script type="text/javascript">
                            $(".snippet-dropdown").select2();
                        </script>
                    <?php endif;
            break;

            case 'product_snippet' :
            if ($model->parent && $product) : ?>
                        <span>Produktový snippet <?= $model->parent->productVarValue->var->name ?></span>
                    <?php else : ?>
                <?= Html::activeDropDownList($model, 'parent_id',
                    ArrayHelper::map($product->productSnippets, 'id', 'varIdentifier'),
                    [
                        'name' => $prefix . '[parent_id]',
                        'class' => 'parent-dropdown form-control',
                        'data-prefix' => $prefix,
                        'data-type' => $model->type,
                        'prompt' => 'Vyber produktový snippet'
                    ]) ?>
            <?php endif;

            break;

            case 'portal_snippet' :
            if ($model->parent) : ?>
                        <span>Portálový snippet <?= $model->parent->portalVarValue->var->name ?></span>
            <?php else : ?>
                <?= Html::activeDropDownList($model, 'parent_id',
                    ArrayHelper::map(BaseController::$portal->portalSnippets,
                        'id', 'varIdentifier'),
                    [
                        'name' => $prefix . '[parent_id]',
                        'class' => 'parent-dropdown form-control',
                        'data-prefix' => $prefix,
                        'data-type' => $model->type,
                        'prompt' => 'Vyber portálový snippet',
                    ]) ?>
            <?php endif;

                break;
            } ?>
        </span>
    </div>

    <div class="modal-body">
        <?php
        foreach ($model->snippetVarValues as $indexVar => $snippetVarValue) {
            echo $this->render('_snippet-var-value', [
                'snippetVarValue' => $snippetVarValue,
                'product' => $product,
                'prefix' => $prefix . "[SnippetVarValue][$indexVar]",
                'parentId' => $model->parent_id
            ]);
        }
        ?>
    </div>
</div>

<script type="text/javascript">
    var changeUrl = '<?= Url::to(['/snippet/get-snippet-code-variables', 'id' => '1']) ?>';

    $(".change-snippet-code.not-applied").bind('change', function (e) {
        var $this = $(this);

        $.get(changeUrl.replace('1', $(this).val()), function (data) {
            var items = $this.parents('.col-md-12').first().find('.modal-body .snippet-var-value');
            console.log(data);
            items.show();
            items.each(function () {
                var _this = $(this);
                if (data.indexOf(_this.attr('data-identifier')) == -1) {
                    _this.hide();
                    console.log("hiding " + _this.attr('data-identifier'));
                }
            });
        });
    }).trigger('change').removeClass('not-applied');
</script>


