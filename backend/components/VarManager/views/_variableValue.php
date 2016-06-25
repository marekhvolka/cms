<?php
use backend\models\Page;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $varValue */
/* @var $index int */
?>

<?php
// Name of model class without path for creating name attributes for inputs 
// used in post request parameters in form and eventually in controller.
if (!isset($index)) {
    $index = rand(0, 10000000);
} // Index for correctly indexing Post request variable.
?>

<div class="form-group variable-value active-field">
    <label class="col-sm-2 control-label label-var"><?= $varValue->var->name ?></label>
    <div class="col-sm-10 var-value">
        <div class="input-group">
            <?= Html::activeHiddenInput($varValue, 'id', [
                'name' => 'Var[' . $index . '][id]'
            ]); ?>
            <?= Html::activeHiddenInput($varValue, 'var_id', [
                'name' => 'Var[' . $index . '][var_id]'
            ]); ?>

            <?= Html::hiddenInput('Var[' . $index . '][existing]',
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
                        'name' => 'Var[' . $index . '][value_text]',
                    ]);
                    break;
                case 'page':
                    echo Html::activeDropDownList($varValue, 'value_page_id',
                        ArrayHelper::map(Page::find()->all(), 'id', 'breadcrumbs'),
                        [
                            'name' => 'Var[' . $index . '][value_page_id]',
                            'class' => 'form-control',
                            'prompt' => 'Vyber podstránku'
                        ]);
                    break;
                default:
                    echo Html::activeTextInput($varValue, 'value_text', [
                        'class' => 'form-control',
                        'name' => 'Var[' . $index . '][value_text]',
                    ]);
                    break;
            }
            ?>

            <span class="input-group-btn remove-btn">
                <button class="btn btn-danger remove-var-value" type="button">
                    <span class="glyphicon glyphicon-remove"></span>
                </button>
            </span>
        </div>
    </div>
</div>
