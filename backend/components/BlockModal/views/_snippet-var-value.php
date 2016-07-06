<?php
use backend\models\Portal;
use backend\models\ProductVar;
use backend\models\Tag;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;
use yii\helpers\Html;

/* @var $snippetVarValue backend\models\SnippetVarValue */
/* @var $product backend\models\Product */
/* @var $prefix string */
/* @var $defaultValue \backend\models\SnippetVarDefaultValue */
/* @var $globalObjects array */
/* @var $parentId int */
?>

<?php
if ($product) {
    $productType = $product->productType;
} else {
    $productType = null;
}
$defaultValue = $snippetVarValue->var->getDefaultValue($productType);

if ($snippetVarValue->typeName != 'list') : ?>
    <div class="form-group">
        <label class="col-sm-2 control-label"
               for="<?= $snippetVarValue->id ?>"><?= $snippetVarValue->var->identifier ?></label>
        <?= BaseHtml::hiddenInput($prefix . "[var_id]", $snippetVarValue->var_id, ['class' => 'var_id']); ?>
        <div class="col-sm-10">
            <?php
            switch ($snippetVarValue->typeName) {
                case 'image': ?>
                    <input type="text" class="form-control" id="<?= $snippetVarValue->id ?>"
                           name="<?= $prefix . '[value_text]' ?>"
                           placeholder="<?= $defaultValue ? htmlentities($defaultValue->value_text) : '' ?>"
                           value="<?= htmlspecialchars($snippetVarValue->value_text, ENT_QUOTES) ?>"/>
                    <?php
                    break;
                case 'url' :
                case 'icon' :
                case 'textinput' : ?>

                    <input type="text" class="form-control" id="<?= $snippetVarValue->id ?>"
                           name="<?= $prefix . '[value_text]' ?>"
                           placeholder="<?= $defaultValue ? htmlentities($defaultValue->value_text) : '' ?>"
                           value="<?= htmlspecialchars($snippetVarValue->value_text, ENT_QUOTES) ?>"/>
                    <?php
                    break;
                case 'textarea' : ?>

                    <textarea class="form-control" id="<?= $snippetVarValue->id ?>"
                              name="<?= $prefix . '[value_text]' ?>"
                              rows="3" placeholder="<?= $defaultValue ? htmlentities($defaultValue->value_text) : '' ?>"
                    ><?= htmlspecialchars($snippetVarValue->value_text, ENT_QUOTES) ?></textarea>

                    <?php
                    break;
                case 'color' : ?>
                    <div class="input-group">
                        <input type="color" class="form-control" id="<?= $snippetVarValue->id ?>" name=""
                               value="<?= $snippetVarValue->value_text ?>"
                               placeholder="<?= $defaultValue ? $defaultValue->value_text : '' ?>">
                        <span class="input-group-addon"><i></i></span>
                    </div>

                    <?php
                    break;
                case 'editor' : ?>
                    <textarea class="form-control" id="<?= $snippetVarValue->id ?>" name="" rows="3"
                              placeholder="<?= $defaultValue ? htmlentities($defaultValue->value_text) : '' ?>">
                        <?= htmlspecialchars($snippetVarValue->value_text, ENT_QUOTES) ?>
                    </textarea>
                    <?php
                    break;
                case 'product' : ?>

                    <?= Html::activeDropDownList($snippetVarValue, 'value_product_id',
                        ArrayHelper::map(Portal::findOne(Yii::$app->session->get('portal_id'))->language->products,
                            'id', 'name')
                        ,
                        [
                            'name' => $prefix . '[value_product_id]',
                            'class' => 'form-control',
                            'prompt' => 'Vyber produkt'
                        ]) ?>

                    <?php
                    break;
                case 'page' : ?>

                    <?= Html::activeDropDownList($snippetVarValue, 'value_page_id',
                        ArrayHelper::map(Portal::findOne(Yii::$app->session->get('portal_id'))->pages, 'id',
                            'breadcrumbs')
                        ,
                        [
                            'name' => $prefix . '[value_page_id]',
                            'class' => 'form-control',
                            'prompt' => 'Vyber podstránku'
                        ]) ?>


                    <?php
                    break;
                case 'product_var' : ?>

                    <?= Html::activeDropDownList($snippetVarValue, 'value_product_var_id',
                        ArrayHelper::map(ProductVar::find()->all(), 'id', 'name')
                        ,
                        [
                            'name' => $prefix . '[value_product_var_id]',
                            'class' => 'form-control',
                            'prompt' => 'Vyber produktovú premennú'
                        ]) ?>

                    <?php
                    break;
                case 'product_tag' : ?>

                    <?= Html::activeDropDownList($snippetVarValue, 'value_tag_id',
                        ArrayHelper::map(Tag::find()->all(), 'id', 'label')
                        ,
                        [
                            'name' => $prefix . '[value_tag_id]',
                            'class' => 'form-control',
                            'prompt' => 'Vyber tag'
                        ]) ?>

                    <?php
                    break;

                case 'dropdown' : ?>

                    <?= Html::activeDropDownList($snippetVarValue, 'value_dropdown_id',
                        ArrayHelper::map($snippetVarValue->var->dropdownValues, 'id', 'value'),
                        [
                            'name' => $prefix . '[value_dropdown_id]',
                            'class' => 'form-control'
                        ]) ?>

                    <?php
                    break;

                case 'bool' : ?>

                    <?= Html::activeCheckbox($snippetVarValue, 'value_text', [
                        'name' => $prefix . '[value_text]',
                    ]) ?>

                    <?php
                    break;
            } ?>
            <?php if (!empty($defaultValue)) : ?>
                <p class="text-muted doplnInfo">Prednastavená hodnota pre toto pole je
                    <strong><?= $defaultValue ? htmlentities($defaultValue->value_text) : '' ?></strong></p>
            <?php endif; ?>
        </div>
        <div class="clearfix"></div>
    </div>
<?php elseif (!isset($parentId)) : ?>
    <div class="panel panel-collapsable panel-container list-panel">
        <?= BaseHtml::hiddenInput($prefix . "[var_id]", $snippetVarValue->var_id, ['class' => 'var_id']); ?>
        <div class="panel-heading">
            <span>
                <?= $snippetVarValue->var->identifier ?>
            </span>
            <span>
                Počet položiek: <span class="list-items-count"><?= sizeof($snippetVarValue->listItems) ?></span>
            </span>
            <a class="btn btn-success btn-xs pull-right btn-add-list-item"
               data-prefix="<?= $prefix ?>" data-parent-var-id="<?= $snippetVarValue->var_id ?>"
                data-parent-id="<?= $parentId ?>">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        </div>

        <div class="panel-body panel-collapse collapse in children-list fixed-panel">
            <?php foreach ($snippetVarValue->listItems as $indexItem => $listItem) : ?>
                <?= $this->render('_list-item', [
                    'listItem' => $listItem,
                    'product' => $product,
                    'prefix' => $prefix . "[ListItem][$indexItem]",
                    'parentId' => $parentId
                ]); ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif;
