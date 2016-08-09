<?php
use backend\components\BlockModal\BlockModalWidget;
use backend\models\Portal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model */
/* @var $varValue */
/* @var $prefix string */

if (!isset($model)) {
    $model = Portal::findOne(Yii::$app->user->identity->portal);
}

if (!isset($renderModal)) {
    $renderModal = false;
}
?>

<div class="form-group active-field">
    <label class="col-sm-2 control-label label-var"><?= $varValue->var->name ?></label>
    <div class="col-sm-10 var-value" id="var-<?= $varValue->id ?>">
        <div class="input-group">
            <?= Html::activeHiddenInput($varValue, 'id', [
                'name' => $prefix . '[id]'
            ]); ?>
            <?= Html::activeHiddenInput($varValue, 'var_id', [
                'name' => $prefix . '[var_id]'
            ]); ?>

            <?= Html::hiddenInput($prefix . '[existing]',
                $varValue->id ? 'true' : 'false'); ?>

            <?php if ($varValue->var->description): ?>
                <span class="input-group-addon">
                    <a class='my-tool-tip' data-toggle="tooltip" data-placement="left"
                       title="<?= $varValue->var->description ?>">
                        <!-- The class CANNOT be tooltip... -->
                        <i class='glyphicon glyphicon-question-sign'></i>
                    </a>
                </span>
            <?php endif; ?>
            <?php
            switch ($varValue->var->type->identifier) {
                case 'textarea':
                    echo Html::activeTextarea($varValue, 'value_text', [
                        'class' => 'form-control',
                        'rows' => 5,
                        'placeholder' => $varValue->var->name,
                        'name' => $prefix . '[value_text]',
                    ]);
                    break;
            case 'page':
                echo Html::activeDropDownList($varValue, 'value_page_id',
                    ArrayHelper::map($model->pages, 'id', 'breadcrumbs'),
                    [
                        'name' => $prefix . '[value_page_id]',
                        'class' => 'form-control select2',
                        'prompt' => 'Vyber podstránku'
                    ]);

                ?>
                <script type="text/javascript">
                    $(".select2").select2();
                </script>
            <?php
            break;
            case 'image':
                echo Html::activeTextInput($varValue, 'value_text', [
                    'class' => 'form-control value',
                    'name' => $prefix . '[value_text]',
                ]);

                echo '<span class="input-group-btn">';
                echo Html::a('<span class="fa fa-fw fa-picture-o"></span>', "#",
                    ['class' => 'pull-right btn btn-success open-multimedia']);
                echo '</span>';
                break;
            case 'portal_snippet':
            case 'product_snippet': ?>
                <div class="btn-group layout-block block"
                     data-content="" role="group">
                    <?= Html::hiddenInput($prefix . "[type]", $varValue->valueBlock->type, ['class' => 'type']); ?>
                    <?= Html::hiddenInput($prefix . "[existing]", !$varValue->isNewRecord,
                        ['class' => 'existing']); ?>
                    <?= Html::hiddenInput($prefix . "[id]", $varValue->id, ['class' => 'id']); ?>


                    <button type="button" class="btn btn-default btn-sm text-content-btn btn-block-modal"
                            data-id="<?= $varValue->valueBlock->id ?>" data-prefix="<?= $prefix ?>"
                            data-portal-id="<?= $model->id ?>" data-target="#modal-<?= $varValue->id ?>">
                        <?php echo $varValue->valueBlock->name; ?>
                    </button>
                    <?php if ($varValue->valueBlock->snippetCode) : ?>
                        <?=
                        Html::a(
                            '<span class="glyphicon glyphicon-link"></span>', $varValue->valueBlock->snippetCode->url, [
                                'class' => 'btn btn-info btn-sm',
                                'title' => 'Upraviť snippet',
                                'target' => '_blank'
                            ]
                        ) ?>

                        <?php if (!$varValue->isNewRecord): ?>
                            <button type="button"
                                    class="btn btn-default btn-sm text-content-btn block-usage"
                                    data-toggle="modal"
                                    data-target="#productUsedIn[data-id='<?= $varValue->id ?>']">
                                <i class="glyphicon glyphicon-question-sign"></i>
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="modal-container">
                        <?php if (Yii::$app->request->get('duplicate') || $renderModal) {
                            echo BlockModalWidget::widget([
                                'block' => $varValue->valueBlock,
                                'page' => null,
                                'portal' => $model->className() == Portal::className() ? $model : null,
                                'prefix' => $prefix
                            ]);
                        } ?>
                    </div>
                    <?php if (!$varValue->isNewRecord) : ?>
                        <div class="usages">
                            <div class="modal fade" id="productUsedIn" data-id="<?= $varValue->id ?>" tabindex="-1"
                                 role="dialog"
                                 aria-labelledby="productUsedInLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Zavrieť">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title" id="alternativeUsedInLabel">Použitie snippetu</h4>
                                        </div>
                                        <div class="modal-body">
                                            <?= $this->render('_product-var-block-usage',
                                                ['block' => $varValue->valueBlock]) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php
            break;
            case 'date':
                echo DatePicker::widget([
                    'value' => $varValue->value_text,
                    'attribute' => 'from_date',
                    //'language' => 'ru',
                    'dateFormat' => 'yyyy/MM/dd',
                    'class' => 'form-control',
                    'name' => $prefix . "[value_text]",
                ]);
                break;
            case 'color':

            ?>
                <div class="input-group apply-spectrum spectrum-parent">
                        <span class="color-picking">
                            <input type="text" class="apply-spectrum-picker picker"
                                   value="<?= $varValue->value_text ?>">
                        </span>
                    <input type="text" class="form-control apply-spectrum-source source"
                           name="<?= $prefix . '[value_text]' ?>"
                           value="<?= $varValue->value_text ?>">
                </div>
                <script>if (applySpectrum != null)
                    {
                        applySpectrum();
                    }</script>
                <?php

                break;
                default:
                    echo Html::activeTextInput($varValue, 'value_text', [
                        'class' => 'form-control',
                        'name' => $prefix . '[value_text]',
                    ]);
                    break;
            }
            ?>

            <span class="input-group-btn remove-btn" data-id="<?= $varValue->var_id ?>">
                <a class="btn btn-danger remove-var-value" type="button">
                    <i class="glyphicon glyphicon-remove"></i>
                </a>
            </span>
        </div>
    </div>
</div>
