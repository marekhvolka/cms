<?php
use backend\models\ProductType;
use yii\bootstrap\BaseHtml;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $defaultValue backend\models\SnippetVarDefaultValue */
/* @var $withoutProduct bool */

if (!isset($withoutProduct)) {
    $withoutProduct = false;
}

// Index for correctly indexing Post request variable, bad idea but I was told that it does not matter
$postIndex = rand(0, 10000000);

?>
<div class="row">
    <div class="col-sm-12">
        <?php if (!$withoutProduct) { ?>
            <div class="col-sm-4 column-without-padding">
                <?= BaseHtml::activeDropDownList($defaultValue, "product_type_id", ArrayHelper::map(
                    ProductType::find()->all(), "id", "name"
                ), [
                    'class'  => 'form-control select-var-type',
                    'prompt' => 'Vyber typ produktu',
                    'name' => "SnippetVarDefaultValue[$postIndex][product_type_id]"
                ]);
                ?>
            </div>
        <?php } else { ?>
            <label class="control-label" for="snippetvar-default_value">
                <?= $defaultValue->getAttributeLabel('value'); ?>
            </label>
        <?php } ?>
        <div class="col-sm-<?= $withoutProduct ? '12' : '8' ?> column-without-padding">
            <?= BaseHtml::activeTextInput($defaultValue, "value", [
                'class' => 'form-control',
                'name'  => "SnippetVarDefaultValue[$postIndex][default_value]",
            ]); ?>
            <?php if (!$withoutProduct) { ?>
                <button type="button" class="btn-remove-snippet-default-value btn btn-danger btn-xs pull-right"
                        data-default-value-id="<?= $defaultValue->id; ?>">
                    <i class="glyphicon glyphicon-minus"></i>
                </button>
            <?php } ?>
            <button type="button" class="btn-add-snippet-default-value btn btn-success btn-xs pull-right">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
        </div>
    </div>
</div>