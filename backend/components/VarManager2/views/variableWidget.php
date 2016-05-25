<?php

use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $assignedVariableValues is used for update - all variables which previously set and currently are updated */
/* @var $allVariables */
/* @var $appendVarValueUrl Url of controller action used for appending new variable value. */

?>

<label class="control-label">Premenné</label>

<div id="dynamic-fields" class="row">
    <?php
    foreach ($assignedVariableValues as $variableValue) {
        echo $this->render('_variableValue', ['varValue' => $variableValue]);
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
            ],
        ]);
        ?>
    </div>
</div>

<?php
// Code inserted as javascript - creating array of assigned Variable IDs 
// for removing this variables from dropdown.
$assignedVariableIds = '[';

if (!empty($assignedVariableValue)) {
    for ($index = 0; $index < sizeof($assignedVariableValue - 1); $index++) {
        $assignedVariableIds .= $assignedVariableValue->var->id . ', ';
    }
}

$assignedVariableIds .= ']';

$js = <<<JS

var selectedVarIds = $assignedVariableIds;
var appendUrl = '$appendVarValueUrl?id=';
        
JS;
$this->registerJs($js, \yii\web\View::POS_BEGIN);
?>