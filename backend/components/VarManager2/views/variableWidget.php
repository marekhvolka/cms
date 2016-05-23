<?php

use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $assignedVariableValues */
/* @var $allVariables */
?>
<?php
$modelClassName = \yii\helpers\StringHelper::basename($variableValueClassName);
?>

<div id="dynamic-fields" class="row">
    <?php
    foreach ($assignedVariableValues as $variableValue) {
        echo $this->render('_variableValue', [
            'varValue' => $variableValue, 
            'type' => $modelClassName
        ]);
    }
    ?>
</div>

<label class="control-label">Variables</label>

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

<?php
$assignedVariableIds = '[';

if (!empty($assignedVariableValue)) {
    for ($index = 0; $index < sizeof($assignedVariableValue - 1); $index++) {
        $assignedVariableIds .= $assignedVariableValue->var->id . ', ';
    }
}

$assignedVariableIds .= ']';

$secondGetParameter = $str = str_replace('\\', '-', $variableValueClassName);

$js = <<<JS

var selectedVarIds = $assignedVariableIds;
var appendUrl = '$appendVarValueUrl?id=';
var appendUrlSecondPart = '&type=$secondGetParameter';
var modelClassName = '$modelClassName';

for (var i = 0; i < selectedVarIds.length; i++) {
    $('#types-dropdown').find('[value="' + selectedVarIds[i] + '"]').prop('disabled', true); //skryjeme uz pridane premenne
}

$('#types-dropdown').select2();

$('#types-dropdown').change(function () {
    var fieldId = $(this).val();
    var source = $('.field-' + fieldId);

    $.get(appendUrl + fieldId + appendUrlSecondPart, function (data) {
        $('#dynamic-fields').append(data); //pripojime vygenerovany view do zoznamu
    });

    $('#types-dropdown').find('[value="' + fieldId + '"]').prop('disabled', true); //zneviditelnime polozku v dropdowne
    $('#types-dropdown').select2();
});

function attachRemove() {
    $('.rmv-btn').click(function () {
        var id = $(this).attr('data-field-id');
        var elementClass = '.field-' + id + '.active-field';
        $(elementClass).remove();

        $('#types-dropdown').find('option').prop('disabled', false);
        $('#types-dropdown').select2();
    });
}
        
JS;
$this->registerJs($js); //, \yii\web\View::POS_BEGIN);
?>