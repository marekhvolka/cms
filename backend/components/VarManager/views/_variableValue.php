<?php
use backend\models\Portal;
use kartik\color\ColorInput;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model */
/* @var $varValue */
/* @var $prefix string */

if (!isset($model)) {
    $model = Portal::findOne(Yii::$app->request->get('portal_id'));
}
?>

<div class="form-group variable-value active-field">
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
                            'class' => 'form-control',
                            'prompt' => 'Vyber podstránku'
                        ]);
                    break;
                case 'image':
                    echo Html::activeTextInput($varValue, 'value_text', [
                        'class' => 'form-control value',
                        'name' => $prefix . '[value_text]',
                    ]);

                    echo '<span class="input-group-btn">';
                    echo Html::a('<span class="fa fa-fw fa-picture-o"></span>', "#", ['class' => 'pull-right btn btn-success',
                        'data-toggle' => "modal", 'data-target' => '#multimediaWidget']);
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
                                data-target="#modal-<?= $varValue->id ?>">
                            <?php echo $varValue->valueBlock->name; ?>
                        </button>

                        <?=
                        Html::a(
                            '<span class="glyphicon glyphicon-link"></span>', $varValue->valueBlock->snippetCode->url, [
                                'class' => 'btn btn-info btn-sm',
                                'title' => 'Upraviť snippet',
                                'target' => '_blank'
                            ]
                        ) ?>

                        <div class="modal-container">

                        </div>
                    </div>
                    <?php
                    break;
                case 'date':
                    echo DatePicker::widget([
                        'name' => $prefix . "[value_text]",
                        'type' => DatePicker::TYPE_INPUT,
                        'value' => $varValue->value_text,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd/mm/yyyy'
                        ],
                        'class' => 'form-control'
                    ]);
                    break;
                case 'color':
                    echo ColorInput::widget([
                        'name' => $prefix . "[value_text]",
                        'value' => $varValue->value_text,
                        'pluginOptions' => [
                            'showAlpha' => false,
                        ]
                    ]);
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
