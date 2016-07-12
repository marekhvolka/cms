<?php

use backend\components\MultimediaWidget\MultimediaWidget;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $assignedVariableValues is used for update - all variables which previously set and currently are updated */
/* @var $allVariables */
/* @var $appendVarValueUrl Url of controller action used for appending new variable value. */
/* @var $model */
/* @var $prefix string */

?>

<?= MultimediaWidget::widget(['renderAsModal' => true, 'onlyImages' => true]) ?>

    <h3>Premenné</h3>

    <div id="dynamic-fields" class="row">
        <?php
        foreach ($assignedVariableValues as $variableIndex => $variableValue) {
            echo $this->render('_variableValue', [
                'varValue' => $variableValue,
                'model' => $model,
                'prefix' => $prefix . "[$variableIndex]"
            ]);
        }
        ?>
    </div>

    <div class="form-group">
        <label class="col-sm-2 label-var">Výber premennej</label>
        <div class="col-sm-10">
            <?=
            Select2::widget([
                'name' => 'vars',
                'data' => ArrayHelper::map($allVariables, 'id', 'name'),
                'options' => [
                    'placeholder' => 'Vyber premennú ...',
                    'id' => 'types-dropdown',
                    'data-prefix' => $prefix,
                    'data-model-id' => $model->id
                ],
            ]);
            ?>
        </div>
    </div>
<?php
// Code inserted as javascript - creating array of assigned Variable IDs 
// for removing this variables from dropdown.
$assignedVariableIds = '[';

if (!empty($assignedVariableValues)) {
    for ($index = 0; $index < sizeof($assignedVariableValues); $index++) {
        $assignedVariableIds .= $assignedVariableValues[$index]->var->id . ', ';
    }
}

$assignedVariableIds .= ']';

$js = <<<JS

var selectedVarIds = $assignedVariableIds;
var appendVarValueUrl = '$appendVarValueUrl';
        
JS;
$this->registerJs($js, \yii\web\View::POS_BEGIN);
?>