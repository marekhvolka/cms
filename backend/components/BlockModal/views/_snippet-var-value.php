<?php
use backend\controllers\BaseController;
use backend\models\ProductVar;
use backend\models\Tag;
use common\components\Icons;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;
use yii\helpers\Html;

/* @var $snippetVarValue backend\models\SnippetVarValue */
/* @var $page backend\models\Page */
/* @var $portal backend\models\Portal */
/* @var $prefix string */
/* @var $defaultValue \backend\models\SnippetVarDefaultValue */
/* @var $globalObjects array */
/* @var $parentId int */

?>

<div class="snippet-var-value" data-identifier="<?= $snippetVarValue->var->identifier ?>">
    <?php
    $product = $page && $page->product ? $page->product : null;
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
            <?= BaseHtml::hiddenInput($prefix . "[var_id]", $snippetVarValue->var_id, ['class' => 'var_id']); ?>
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
                        <?= Html::a('<span class="fa fa-fw fa-picture-o"></span>', "#", ['class' => 'pull-right open-multimedia btn btn-success']) ?>
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
                            <input type="text" class="apply-spectrum-picker picker" value="<?= $snippetVarValue->value_text ?>">
                        </span>
                        <input type="text" class="form-control apply-spectrum-source source" id="<?= $snippetVarValue->id ?>"
                               name="<?= $prefix . '[value_text]' ?>"
                               value="<?= $snippetVarValue->value_text ?>"
                               placeholder="<?= $defaultValue ? $defaultValue->value_text : '' ?>">
                        <span class="input-group-addon"><i></i></span>
                    </div>

                    <script type="text/javascript">
                        var apply = $(".apply-spectrum");
                        apply.find(".apply-spectrum-picker").spectrum({
                            preferredFormat: "hex",
                            change: function(color) {
                                $(this).parents('.spectrum-parent').first().find('.source').val(color);
                            }
                        }).removeClass('apply-spectrum-picker');

                        apply.find('.apply-spectrum-source').on('input', function(){
                            var $this = $(this);
                            $this.parents('.spectrum-parent').first().find('.picker').spectrum('set', $this.val());
                        }).removeClass('apply-spectrum-source');

                        apply.removeClass('apply-spectrum');
                    </script>

                <?php
                break;
                case 'editor' : ?>
                    <textarea class="form-control" id="ckeditor<?= $snippetVarValue->id ?>"
                              name="<?= $prefix . '[value_text]' ?>"
                              placeholder="<?= $defaultValue ? htmlentities($defaultValue->value_text) : '' ?>">
                        <?= htmlspecialchars($snippetVarValue->value_text, ENT_QUOTES) ?>
                    </textarea>

                    <script type="text/javascript">
                        CKEDITOR.replace("ckeditor<?= $snippetVarValue->id ?>", ckeditorConfig);
                    </script>

                <?php
                break;
                case 'product' : ?>

                    <?= Html::activeDropDownList($snippetVarValue, 'value_product_id',
                        ArrayHelper::map($page ? $page->portal->language->products : $portal->language->products,
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
                        ArrayHelper::map($page ? $page->portal->pages : $portal->pages, 'id',
                            'breadcrumbs'),
                        [
                            'name' => $prefix . '[value_page_id]',
                            'class' => 'form-control activate-select2',
                            'prompt' => 'Vyber podstránku'
                        ]) ?>


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

                <?= SwitchInput::widget([
                    'name' => $prefix . '[value_text]',
                    'value' => $snippetVarValue->value_text,
                    'type' => SwitchInput::CHECKBOX,
                    'containerOptions' => [
                        'class' => 'form-group apply-child-bootstrap-switch'
                    ]
                ]) ?>
                    <script type="text/javascript">
                        var toApply = $(".apply-child-bootstrap-switch");
                        toApply.find("input").bootstrapSwitch();
                        toApply.removeClass('apply-child-bootstrap-switch');
                    </script>

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
                            return '<span class="' + o.id + '"></span> ' + o.text.slice(3).replace('-', ' ') + ' [font awesome]';
                        } else if (o.id.match(/glyphicon\-[a-z\-]+/)) {
                            return '<span class="' + o.id + '"></span> ' + o.text + ' [glyphicon]';
                        }
                    }

                    return o.text;
                }

                $(".activate-select2").select2({
                    templateResult: format,
                    templateSelection: format,
                    escapeMarkup: function (m) {
                        return m;
                    }
                }).removeClass('activate-select2');
            </script>
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
                   data-parent-id="<?= $parentId ?>" data-page-id="<?= $page ? $page->id : '' ?>" data-portal-id="<?= $portal ? $portal->id : '' ?>">
                    <span class="glyphicon glyphicon-plus"></span>
                </a>
            </div>

        <div class="panel-body panel-collapse collapse in children-list list-items fixed-panel">
            <?php foreach ($snippetVarValue->listItems as $indexItem => $listItem) : ?>
                <?= $this->render('_list-item', [
                    'listItem' => $listItem,
                    'page' => $page,
                    'portal' => $portal,
                    'prefix' => $prefix . "[ListItem][$indexItem]",
                    'parentId' => $parentId
                ]); ?>
            <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>