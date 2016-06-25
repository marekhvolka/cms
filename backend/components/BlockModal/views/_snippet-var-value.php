<?php
use backend\models\Page;
use backend\models\Product;
use backend\models\Tag;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use kartik\color\ColorInput;
use yii\helpers\BaseHtml;
use yii\helpers\Html;
use backend\models\SnippetVarValue;

/* @var $model backend\models\SnippetVarValue */
/* @var $productType backend\models\ProductType */
/* @var $prefix string */

?>

<?php
$defaultValue = $model->getDefaultValue($productType);

if ($model->typeName != 'list') : ?>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="<?= $model->id ?>"><?= $model->var->identifier ?></label>
        <div class="col-sm-10">
            <?php
            switch ($model->typeName) {
                case 'url' :
                case 'textinput' : ?>

                    <input type="text" class="form-control" id="<?= $model->id ?>"
                           name="<?= $prefix . '[value_text]' ?>"
                           placeholder="<?= htmlentities($model->getDefaultValue($productType)) ?>"
                           value="<?= htmlspecialchars($model->value_text, ENT_QUOTES) ?>"/>


                    <?php
                    break;
                case 'textarea' : ?>

                    <textarea class="form-control" id="<?= $model->id ?>" name="<?= $prefix . '[value_text]' ?>"
                              rows="3"
                              placeholder="<?= htmlentities($model->getDefaultValue($productType)) ?>"><?= htmlspecialchars($model->value_text,
                            ENT_QUOTES) ?></textarea>


                    <?php
                    break;
                case 'color' : ?>

                    <div class="input-group">
                        <input type="color" class="form-control" id="<?= $model->id ?>" name=""
                               value="<?= $model->value_text ?>"
                               placeholder="<?= $model->getDefaultValue($productType) ?>">
                        <span class="input-group-addon"><i></i></span>
                    </div>


                    <?php
                    break;
                case 'editor' : ?>

                    <textarea class="form-control" id="<?= $model->id ?>" name="" rows="3"
                              placeholder="<?= htmlentities($model->getDefaultValue($productType)) ?>"><?= htmlspecialchars($model->value_text,
                            ENT_QUOTES) ?></textarea>


                    <?php
                    break;
                case 'product' : ?>

                    <?= Html::activeDropDownList($model, 'value_product_id',
                        ArrayHelper::map(Product::find()->all(), 'id', 'name'),
                        [
                            'name' => $prefix . '[value_product_id]',
                            'class' => 'form-control',
                            'prompt' => 'Vyber produkt'
                        ]) ?>

                    <?php
                    break;
                case 'page' : ?>

                    <?= Html::activeDropDownList($model, 'value_page_id',
                        ArrayHelper::map(Page::find()->all(), 'id', 'breadcrumbs'),
                        [
                            'name' => $prefix . '[value_page_id]',
                            'class' => 'form-control',
                            'prompt' => 'Vyber podstránku'
                        ]) ?>


                    <?php
                    break;

                case 'tag' : ?>

                    <?= Html::activeDropDownList($model, 'value_tag_id',
                        ArrayHelper::map(Tag::find()->all(), 'id', 'label'),
                        [
                            'name' => $prefix . '[value_tag_id]',
                            'class' => 'form-control',
                            'prompt' => 'Vyber tag'
                        ]) ?>

                    <?php
                    break;

                case 'dropdown' : ?>

                    <?= Html::activeDropDownList($model, 'value_tag_id',
                        ArrayHelper::map($model->var->dropdownValues, 'id', 'value'),
                        [
                            'name' => $prefix . '[value_dropdown_id]',
                            'class' => 'form-control'
                        ]) ?>

                    <?php
                    break;

                case 'bool' : ?>

                    <?= SwitchInput::widget(['name' => $prefix . 'value_text', 'value' => $model->var->value_text]); ?>

                    <?php
                    break;
            } ?>
            <?php if (!empty($defaultValue)) : ?>
                <p class="text-muted doplnInfo">Prednastavená hodnota pre toto pole je
                    <strong><?= htmlentities($model->getDefaultValue($productType)) ?></strong></p>
            <?php endif; ?>
        </div>
        <div class="clearfix"></div>
    </div>
<?php else  : ?>
    <div class="panel panel-default">
        <div class="panel-heading">
                <span>
                    <a data-toggle="collapse" href="#panel<?= $model->id ?>">
                        <i class="fa fa-angle-down">
                            <?= $model->var->identifier ?>
                        </i>
                    </a>
                </span>
                <span>
                    Počet položiek: <?= sizeof($model->valueListVar->listItems) ?>
                </span>
            <button class="btn btn-success btn-xs pull-right">
                <span class="glyphicon glyphicon-plus"></span>
            </button>
        </div>

        <div class="panel-body panel-collapse collapse in" id="panel<?= $model->id ?>">
            <ul class="list-unstyled">
                <?php foreach ($model->valueListVar->listItems as $indexItem => $listItem) : ?>
                    <li>
                        <?= $this->render('_list-item', [
                            'model' => $listItem,
                            'productType' => $productType,
                            'prefix' => $prefix . "[ListItem][$indexItem]"
                        ]); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif;
