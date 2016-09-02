<?php
use backend\models\LayoutOwner;
use backend\models\ProductVar;
use backend\models\Tag;
use common\components\Icons;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $snippetVarValue backend\models\SnippetVarValue */
/* @var $layoutOwner LayoutOwner */
/* @var $portal backend\models\Portal */
/* @var $prefix string */
/* @var $defaultValue \backend\models\SnippetVarDefaultValue */
/* @var $globalObjects array */
/* @var $parentId int */

?>

<div class="snippet-var-value" data-identifier="<?= $snippetVarValue->var->identifier ?>">
    <?php
    $product = $layoutOwner && $layoutOwner->isPage() && $layoutOwner->product ? $layoutOwner->product : null;
    $defaultValue = $snippetVarValue->var->getDefaultValue($product);

    if ($snippetVarValue->typeName != 'list') : ?>
        <div class="form-group var-value">
            <label class="col-sm-2 control-label"
                   for="<?= $snippetVarValue->id ?>"><?= $snippetVarValue->var->identifier ?>
                <?php if (!empty($snippetVarValue->var->description)) : ?>
                    <a id="tooltip<?= hash('md5', $prefix) ?>" class="popover-btn pull-right" data-toggle="tooltip"
                       data-placement="bottom"
                       title="<?= $snippetVarValue->var->description ?>">
                        <i class="fa fa-question-circle"></i>
                    </a>
                <?php endif; ?>
            </label>
            <?= Html::hiddenInput($prefix . "[var_id]", $snippetVarValue->var_id, ['class' => 'var_id']); ?>
            <div class="col-sm-10">
                <?php
                switch ($snippetVarValue->typeName) {
                case 'image': ?>
                    <div class="input-group">
                        <input type="text" class="form-control value" id="<?= $snippetVarValue->id ?>"
                               name="<?= $prefix . '[value_text]' ?>"
                               placeholder="<?= $defaultValue ? htmlentities($defaultValue->value_text) : '' ?>"
                               value="<?= htmlspecialchars($snippetVarValue->value_text, ENT_QUOTES) ?>"/>
                        <span class="input-group-btn">
                        <?= Html::a('<span class="fa fa-fw fa-picture-o"></span>', "",
                            ['class' => 'pull-right open-multimedia btn btn-success']) ?>
                        </span>
                    </div>
                <?php
                break;
                case 'icon' :
                    ?>
                    <?= Html::activeDropDownList($snippetVarValue, 'value_text',
                    Icons::all(),
                    [
                        'name' => $prefix . '[value_text]',
                        'class' => 'form-control activate-select2',
                        'prompt' => 'Vyber ikonku'
                    ]) ?>
                    <?php
                    break;

                case 'url' :
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
                    <div class="input-group apply-spectrum spectrum-parent">
                        <span class="color-picking">
                            <input type="text" class="apply-spectrum-picker picker"
                                   value="<?= $snippetVarValue->value_text ?>">
                        </span>
                        <input type="text" class="form-control apply-spectrum-source source"
                               id="<?= $snippetVarValue->id ?>"
                               name="<?= $prefix . '[value_text]' ?>"
                               value="<?= $snippetVarValue->value_text ?>"
                               placeholder="<?= $defaultValue ? $defaultValue->value_text : '' ?>">
                        <span class="input-group-addon"><i></i></span>
                    </div>

                    <script type="text/javascript">
                        $(document).ready(function () {
                            var apply = $(".apply-spectrum");
                            apply.find(".apply-spectrum-picker").spectrum(
                                {
                                    preferredFormat: "hex",
                                    change: function (color) {
                                        $(this).parents('.spectrum-parent').first().find('.source').val(color);
                                    }
                                }
                            ).removeClass('apply-spectrum-picker');

                            apply.find('.apply-spectrum-source').on(
                                'input', function () {
                                    var $this = $(this);
                                    $this.parents('.spectrum-parent').first().find('.picker').spectrum('set', $this.val());
                                }
                            ).removeClass('apply-spectrum-source');

                            apply.removeClass('apply-spectrum');
                        });
                    </script>

                <?php
                break;
                case 'editor' : ?>
                <?php $varId = $snippetVarValue->id ? $snippetVarValue->id : rand(100, 10000); ?>
                    <textarea class="form-control" id="ckeditor<?= $varId ?>"
                              name="<?= $prefix . '[value_text]' ?>"
                              placeholder="<?= $defaultValue ? htmlentities($defaultValue->value_text) : '' ?>">
                        <?= htmlspecialchars($snippetVarValue->value_text, ENT_QUOTES) ?>
                    </textarea>

                    <script type="text/javascript">
                        $(document).ready(function () {
                            CKEDITOR.replace("ckeditor<?= $varId ?>", ckeditorConfig);
                            CKEDITOR.dtd.$removeEmpty['i'] = false;
                        });
                    </script>

                    <?php
                    break;
                    case 'product' : ?>

                        <?= Html::activeDropDownList($snippetVarValue, 'value_product_id',
                            ArrayHelper::map($layoutOwner ? $layoutOwner->portal->language->products : $portal->language->products,
                                'id', 'breadcrumbs'),
                            [
                                'name' => $prefix . '[value_product_id]',
                                'class' => 'form-control activate-select2',
                                'prompt' => 'Vyber produkt'
                            ]) ?>

                        <?php
                        break;
                    case 'page' : ?>

                        <?= Html::activeDropDownList($snippetVarValue, 'value_page_id',
                            ArrayHelper::map($layoutOwner ? $layoutOwner->portal->pages : $portal->pages, 'id',
                                'breadcrumbs'),
                            [
                                'name' => $prefix . '[value_page_id]',
                                'class' => 'form-control activate-select2',
                                'prompt' => 'Vyber podstránku'
                            ]) ?>

                        <?php
                        break;
                    case 'post' : ?>

                        <?= Html::activeDropDownList($snippetVarValue, 'value_post_id',
                            ArrayHelper::map($layoutOwner ? $layoutOwner->portal->posts : $portal->posts, 'id',
                                'name'),
                            [
                                'name' => $prefix . '[value_post_id]',
                                'class' => 'form-control activate-select2',
                                'prompt' => 'Vyber článok'
                            ]); ?>

                        <?php
                        break;
                    case 'product_var' : ?>

                        <?= Html::activeDropDownList($snippetVarValue, 'value_product_var_id',
                            ArrayHelper::map(ProductVar::find()->all(), 'id', 'name'),
                            [
                                'name' => $prefix . '[value_product_var_id]',
                                'class' => 'form-control activate-select2',
                                'prompt' => 'Vyber produktovú premennú'
                            ]) ?>

                        <?php
                        break;
                    case 'product_tag' : ?>

                        <?= Html::activeDropDownList($snippetVarValue, 'value_tag_id',
                            ArrayHelper::map(Tag::find()->all(), 'id', 'label'),
                            [
                                'name' => $prefix . '[value_tag_id]',
                                'class' => 'form-control activate-select2',
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

                        <?= Html::checkbox($prefix . '[value_text]', $snippetVarValue->value_text, [
                            'data-check' => 'switch',
                            'data-on-color' => 'primary',
                            'data-on-text' => 'TRUE',
                            'data-off-color' => 'default',
                            'data-off-text' => 'FALSE',
                            'value' => 1,
                            'uncheck' => 0
                        ]) ?>

                        <?php
                        break;
                } ?>
                <?php if (!empty($defaultValue)) : ?>
                    <p class="text-muted doplnInfo">Prednastavená hodnota pre toto pole je
                        <strong><?= $defaultValue ? htmlentities($defaultValue->value_text) : '' ?></strong></p>
                <?php endif; ?>
            </div>
            <script type="text/javascript">
                function format(o) {
                    if (o.id != null) {
                        if (o.id.match(/fa-[a-z\-]+/)) {
                            return '<span class="' + o.id + '"></span> ' + o.text.slice(3).replace(
                                    '-',
                                    ' '
                                ) + ' [font awesome]';
                        }
                        else if (o.id.match(/glyphicon\-[a-z\-]+/)) {
                            return '<span class="' + o.id + '"></span> ' + o.text + ' [glyphicon]';
                        }
                    }

                    return o.text;
                }

                $(document).ready(function () {
                    $(".activate-select2").select2(
                        {
                            templateResult: format,
                            templateSelection: format,
                            escapeMarkup: function (m) {
                                return m;
                            }
                        }
                    ).removeClass('activate-select2');
                });

            </script>
            <div class="clearfix"></div>
        </div>
    <?php elseif (!isset($parentId) || empty($parentId)) : ?>
        <div class="panel panel-collapsable panel-container list-panel">
            <?= Html::hiddenInput($prefix . "[var_id]", $snippetVarValue->var_id, ['class' => 'var_id']); ?>
            <div class="panel-heading">
            <span>
                <?= $snippetVarValue->var->identifier ?>
            </span>
                <span>
                Počet položiek: <span class="list-items-count"><?= sizeof($snippetVarValue->listItems) ?></span>
            </span>
                <div class="dropdown inline-button add-list-item-dropdown pull-right"
                     data-prefix="<?= $prefix ?>"
                     data-parent-var-id="<?= $snippetVarValue->var_id ?>"
                     data-parent-id="<?= $parentId ?>"
                     data-layout-owner-id="<?= $layoutOwner ? $layoutOwner->id : '' ?>"
                     data-layout-owner-type="<?= $layoutOwner ? $layoutOwner->getType() : '' ?>"
                     data-portal-id="<?= $portal ? $portal->id : '' ?>">
                    <button type="button" class="btn btn-success dropdown-toggle btn-xs"
                            title="Vložiť novú položku" data-toggle="dropdown" >
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="btn-add-list-item" data-position="begin">Na začiatok zoznamu</a></li>
                        <li><a class="btn-add-list-item" data-position="middle">Do stredu zoznamu</a></li>
                        <li><a class="btn-add-list-item" data-position="end">Na koniec zoznamu</a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body panel-collapse collapse in children-list list-items fixed-panel">
                <?php foreach ($snippetVarValue->listItems as $indexItem => $listItem) : ?>
                    <?= $this->render('_list-item', [
                        'listItem' => $listItem,
                        'layoutOwner' => $layoutOwner,
                        'portal' => $portal,
                        'prefix' => $prefix . "[ListItem][$indexItem]",
                        'parentId' => $parentId
                    ]); ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>