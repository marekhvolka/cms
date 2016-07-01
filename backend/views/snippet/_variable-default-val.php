<?php
use backend\models\ProductType;
use yii\bootstrap\BaseHtml;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $defaultValue backend\models\SnippetVarDefaultValue */
/* @var $indexDefaultValue int */
/* @var $prefix string */
/* @var $parentPrefix string */

?>
<div class="row">
    <div class="col-sm-12">
        <?php if ($defaultValue->productType) : ?>
            <div class="col-sm-4 column-without-padding">
                <?= BaseHtml::activeDropDownList($defaultValue, "product_type_id", ArrayHelper::map(
                    ProductType::find()->all(), "id", "name"
                ), [
                    'class' => 'form-control select-var-type',
                    'prompt' => 'Vyber typ produktu',
                    'name' => $prefix . "[product_type_id]"
                ]);
                ?>
            </div>
        <?php endif; ?>
        <div class="col-sm-<?= $defaultValue->productType ? '8' : '12' ?> column-without-padding">
            <?= BaseHtml::activeTextInput($defaultValue, "value_text", [
                'class' => 'form-control',
                'name' => $prefix . "[default_value]",
            ]); ?>
            <?php if ($defaultValue->productType) : ?>
                <button type="button" class="btn-remove-snippet-default-value btn btn-danger btn-xs pull-right">
                    <i class="glyphicon glyphicon-minus"></i>
                </button>
            <?php else : ?>
                <button type="button" class="btn-add-snippet-default-value btn btn-success btn-xs pull-right"
                        data-parent-prefix="<?= $parentPrefix ?>">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>