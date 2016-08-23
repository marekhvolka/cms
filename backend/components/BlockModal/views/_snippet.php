<?php
use backend\models\Page;
use backend\models\Portal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $page Page */
/* @var $portal Portal */
/* @var $prefix string */
/* @var $model backend\models\Block */

?>

<div class="col-md-12">
    <?= Html::hiddenInput($prefix . "[parent_id]", $model->parent_id); ?>
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
                    <?php else :
            $snippets = $page ? $page->portal->snippets : $portal->snippets;
            echo Html::dropDownList('snippet_id', null,
                ArrayHelper::map($snippets, 'id', 'name'), [
                    'prompt' => 'Výber snippetu',
                    'class' => 'snippet-dropdown activate-select2',
                    'data-type' => $model->type,
                    'data-prefix' => $prefix,
                    'data-page-id' => $page ? $page->id : '',
                    'data-portal-id' => $portal ? $portal->id : ''
                ]); ?>


                <script type="text/javascript">
                    $(".activate-select2").select2().removeClass('activate-select2');
                </script>
                    <?php endif;
            break;

            case 'product_snippet' :
            if ($model->parent && $page && $page->product) : ?>
                        <span>Produktový snippet <?= $model->parent->productVarValue->var->name ?></span>
                    <?php else : ?>
                <?= Html::activeDropDownList($model, 'parent_id',
                    ArrayHelper::map($page->product->productSnippets, 'id', 'varIdentifier'),
                    [
                        'name' => $prefix . '[parent_id]',
                        'class' => 'parent-dropdown form-control',
                        'data-prefix' => $prefix,
                        'data-type' => $model->type,
                        'data-page-id' => $page ? $page->id : '',
                        'data-portal-id' => $portal ? $portal->id : '',
                        'prompt' => 'Vyber produktový snippet'
                    ]) ?>
            <?php endif;

            break;

            case 'portal_snippet' :
            if ($model->parent) : ?>
                        <span>Portálový snippet <?= $model->parent->portalVarValue->var->name ?></span>
            <?php else : ?>
                <?= Html::activeDropDownList($model, 'parent_id',
                    ArrayHelper::map($portal ? $portal->portalSnippets : $page->portal->portalSnippets,
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
                'page' => $page,
                'portal' => $portal,
                'prefix' => $prefix . "[SnippetVarValue][$indexVar]",
                'parentId' => $model->parent_id
            ]);
        }
        ?>
    </div>
</div>

<script type="text/javascript">
    var changeUrl = '<?= Url::to(['/snippet/get-snippet-code-variables', 'id' => '1']) ?>';

    $(".change-snippet-code.not-applied").bind(
        'change', function (e)
        {
            var $this = $(this);

            $.get(
                changeUrl.replace('1', $(this).val()), function (data)
                {
                    var items = $this.parents('.col-md-12').first().find('.modal-body .snippet-var-value');
                    items.show();
                    items.each(
                        function ()
                        {
                            var _this = $(this);
                            if (data.indexOf(_this.attr('data-identifier')) == -1)
                            {
                                _this.hide();
                            }
                        }
                    );
                }
            );
        }
    ).trigger('change').removeClass('not-applied');
</script>


