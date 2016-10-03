<?php
use backend\models\PartnershipType;
use backend\models\ProductType;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $defaultValue backend\models\SnippetVarDefaultValue */
/* @var $indexDefaultValue int */
/* @var $prefix string */
/* @var $parentPrefix string */
/* @var $forProductType bool */

?>
<div class="row">
    <div class="col-sm-12">

        <?= Html::hiddenInput($prefix . "[removed]", $defaultValue->removed, ['class' => 'removed']); ?>
        <?php if (($defaultValue->productType || $defaultValue->partnershipType) || $forProductType) : ?>
            <div class="col-sm-3 column-without-padding">
                <?= Html::activeDropDownList($defaultValue, "product_type_id", ArrayHelper::map(
                    ProductType::find()->all(), "id", "name"
                ), [
                    'class' => 'form-control select-var-type',
                    'prompt' => 'Vyber typ produktu',
                    'name' => $prefix . "[product_type_id]"
                ]);
                ?>
            </div>
            <div class="col-sm-3 column-without-padding">
                <?= Html::activeDropDownList($defaultValue, "partnership_type_id", ArrayHelper::map(
                    PartnershipType::find()->all(), "id", "name"
                ), [
                    'class' => 'form-control',
                    'prompt' => 'Vyber typ spolupráce',
                    'name' => $prefix . "[partnership_type_id]"
                ]);
                ?>
            </div>
        <?php endif; ?>
        <div class="col-sm-<?= ($defaultValue->productType || $defaultValue->partnershipType) || $forProductType ? '6' : '12' ?> column-without-padding">
            <?= Html::activeTextInput($defaultValue, "value_text", [
                'class' => 'form-control',
                'name' => $prefix . "[value_text]",
            ]); ?>
            <?php if (($defaultValue->productType || $defaultValue->partnershipType) || $forProductType) : ?>
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