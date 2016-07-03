<?php
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;
use yii\helpers\Html;

/* @var $model backend\models\SnippetVarValue */
/* @var $productType backend\models\ProductType */
/* @var $prefix string */
/* @var $defaultValue \backend\models\SnippetVarDefaultValue */
/* @var $globalObjects array */
?>

<?php
$defaultValue = $model->var->getDefaultValue($productType);

if ($model->typeName != 'list') : ?>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="<?= $model->id ?>"><?= $model->var->identifier ?></label>
        <?= BaseHtml::hiddenInput($prefix . "[var_id]", $model->var_id, ['class' => 'var_id']); ?>
        <div class="col-sm-10">
            <?php
            switch ($model->typeName) {
                case 'image': ?>
                    <input type="text" class="form-control" id="<?= $model->id ?>"
                           name="<?= $prefix . '[value_text]' ?>"
                           placeholder="<?= $defaultValue ? htmlentities($defaultValue->value_text) : '' ?>"
                           value="<?= htmlspecialchars($model->value_text, ENT_QUOTES) ?>"/>
                    <?php
                    break;
                case 'url' :
                case 'icon' :
                case 'textinput' : ?>

                    <input type="text" class="form-control" id="<?= $model->id ?>"
                           name="<?= $prefix . '[value_text]' ?>"
                           placeholder="<?= $defaultValue ? htmlentities($defaultValue->value_text) : '' ?>"
                           value="<?= htmlspecialchars($model->value_text, ENT_QUOTES) ?>"/>
                    <?php
                    break;
                case 'textarea' : ?>

                    <textarea class="form-control" id="<?= $model->id ?>" name="<?= $prefix . '[value_text]' ?>"
                              rows="3"
                              placeholder="<?= $defaultValue ? htmlentities($defaultValue->value_text) : '' ?>">
                        <?= htmlspecialchars($model->value_text,
                            ENT_QUOTES) ?></textarea>

                    <?php
                    break;
                case 'color' : ?>
                    <div class="input-group">
                        <input type="color" class="form-control" id="<?= $model->id ?>" name=""
                               value="<?= $model->value_text ?>"
                               placeholder="<?= $defaultValue ? $defaultValue->value_text : '' ?>">
                        <span class="input-group-addon"><i></i></span>
                    </div>

                    <?php
                    break;
                case 'editor' : ?>
                    <textarea class="form-control" id="<?= $model->id ?>" name="" rows="3"
                              placeholder="<?= $defaultValue ? htmlentities($defaultValue->value_text) : '' ?>"><?= htmlspecialchars($model->value_text,
                            ENT_QUOTES) ?></textarea>
                    <?php
                    break;
                case 'product' : ?>

                    <?= Html::activeDropDownList($model, 'value_product_id', $globalObjects['products']
                        ,
                        [
                            'name' => $prefix . '[value_product_id]',
                            'class' => 'form-control',
                            'prompt' => 'Vyber produkt'
                        ]) ?>

                    <?php
                    break;
                case 'page' : ?>

                    <?= Html::activeDropDownList($model, 'value_page_id', $globalObjects['pages']
                        ,
                        [
                            'name' => $prefix . '[value_page_id]',
                            'class' => 'form-control',
                            'prompt' => 'Vyber podstránku'
                        ]) ?>


                    <?php
                    break;
                case 'product_var' : ?>

                    <?= Html::activeDropDownList($model, 'value_product_var_id', $globalObjects['productVars']
                        ,
                        [
                            'name' => $prefix . '[value_product_var_id]',
                            'class' => 'form-control',
                            'prompt' => 'Vyber produktovú premennú'
                        ]) ?>

                    <?php
                    break;
                case 'product_tag' : ?>

                    <?= Html::activeDropDownList($model, 'value_tag_id', $globalObjects['productTags']
                        ,
                        [
                            'name' => $prefix . '[value_tag_id]',
                            'class' => 'form-control',
                            'prompt' => 'Vyber tag'
                        ]) ?>

                    <?php
                    break;

                case 'dropdown' : ?>

                    <?= Html::activeDropDownList($model, 'value_dropdown_id',
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
                    <strong><?= $defaultValue ? htmlentities($defaultValue->value_text) : '' ?></strong></p>
            <?php endif; ?>
        </div>
        <div class="clearfix"></div>
    </div>
<?php else  : ?>
    <div class="panel panel-default list-panel">
        <?= BaseHtml::hiddenInput($prefix . "[var_id]", $model->var_id, ['class' => 'var_id']); ?>
        <div class="panel-heading">
            <span>
                <a data-toggle="collapse" href="#panel<?= $model->id ?>">
                    <i class="fa fa-angle-down">
                        <?= $model->var->identifier ?>
                    </i>
                </a>
            </span>
            <span>
                Počet položiek: <?= sizeof($model->listItems) ?>
            </span>
            <a class="btn btn-success btn-xs pull-right btn-add-list-item"
               data-prefix="<?= $prefix ?>" data-parent-var-id="<?= $model->var_id ?>">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        </div>

        <div class="panel-body panel-collapse collapse in children-list fixed-panel" id="panel<?= $model->id ?>">
            <?php foreach ($model->listItems as $indexItem => $listItem) : ?>
                <?= $this->render('_list-item', [
                    'model' => $listItem,
                    'productType' => $productType,
                    'prefix' => $prefix . "[ListItem][$indexItem]",
                    'globalObjects' => $globalObjects
                ]); ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif;
