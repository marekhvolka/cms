<?php

use backend\components\IdentifierGenerator\IdentifierGenerator;
use backend\components\VarManager\VarManagerWidget;
use backend\models\Language;
use backend\models\PartnershipType;
use backend\models\Product;
use backend\models\ProductType;
use backend\models\Tag;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $allVariables backend\models\ProductVar */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
if ($model->language) {
    $language = $model->language;
} else {
    $language = Yii::$app->user->identity->portal->language;
}

?>
<div class="product-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form',
        'enableAjaxValidation' => true,
    ]); ?>

    <ul class="nav nav-tabs custom-tabs">
        <li role="presentation" class="tab-label active">
            <a href="#tab_basic_settings" data-toggle="tab">Základné nastavenia</a>
        </li>
        <li role="presentation" class="tab-label">
            <a href="#tab_tags_settings" data-toggle="tab">Nastavenia tagov</a>
        </li>
        <li role="presentation" class="tab-label">
            <a href="#tab_variables_settings" data-toggle="tab">Nastavenia premenných</a>
        </li>
    </ul>

    <div class="tab-content custom-tab-content">
        <div class="tab-pane fade in active" id="tab_basic_settings">

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'identifier')->textInput(['maxlength' => true]) ?>

            <?= IdentifierGenerator::widget([
                'idTextFrom' => 'product-name',
                'idTextTo' => 'product-identifier',
                'delimiter' => '_',
            ]) ?>

            <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($language->products, 'id',
                    'breadcrumbs'),
                'language' => 'en',
                'options' => ['placeholder' => 'Výber predka ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

            <?= $form->field($model, 'type_id')->dropDownList(
                ArrayHelper::map(ProductType::find()->all(), 'id', 'name')
            ) ?>

            <?= $form->field($model, 'partnership_type_id')->dropDownList(
                ArrayHelper::map(PartnershipType::find()->all(), 'id', 'name')
            ) ?>

            <?= $form->field($model, 'description')->textarea() ?>

            <?= $form->field($model, 'language_id')->dropDownList(
                ArrayHelper::map(Language::find()->all(), 'id', 'name')
            ) ?>
        </div>

        <div class="tab-pane" id="tab_tags_settings">

            <?= Select2::widget([
                'name' => Product::className() . '[_tags]',
                'value' => array_map(function ($item) {
                    return $item->id;
                }, $model->tags),
                'data' => ArrayHelper::map(Tag::find()->andWhere(
                    [
                        'or',
                        ['like', 'product_type', $model->type_id . ","],
                        ['product_type' => $model->type_id],
                        ['like', 'product_type', "," . $model->type_id . ","],
                        ['like', 'product_type', "," . $model->type_id]
                    ]
                )->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => 'Priradiť tagy',
                    'multiple' => true,
                ],
                'pluginOptions' => [
                    'tags' => true,
                ],
            ]) ?>
        </div>

        <div class="tab-pane" id="tab_variables_settings">
            <?= VarManagerWidget::widget([
                'allVariables' => $allVariables,
                'assignedVariableValues' => $model->productVarValues,
                'appendVarValueUrl' => Url::to(['product/append-var-value']),
                'model' => $model
            ]) ?>
        </div>
    </div>
    <div class="navbar-fixed-bottom">
        <div class="col-sm-10 col-sm-offset-2">
            <div class="form-group">
                <?= Html::submitButton('Uložiť', [
                    'class' => 'btn btn-primary',
                    'id' => 'submit-btn'
                ]) ?>

                <?= Html::submitButton('Uložiť a pokračovať', [
                    'class' => 'btn btn-info',
                    'id' => 'submit-btn',
                    'name' => 'continue'
                ]) ?>

                <?= Html::a('Hard reset', Url::to(['hard-reset', 'id' => $model->id]), [
                    'class' => 'btn btn-danger',
                    'target' => '_blank'
                ]) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
