<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $assignedVariableValues */
/* @var $allVariables */

?>
    <div id="dynamic-fields" class="row">
        <?php foreach ($assignedVariableValues as $variableValue):?>
            <?= $this->render('_variableValue', ['varValue' => $variableValue]); ?>
        <?php endforeach;?>
    </div>

    <label class="control-label">Variables</label>

<?= Select2::widget([
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

foreach($assignedVariableValues as $assignedVariableValue)
{
    $assignedVariableIds .= $assignedVariableValue->var->id . ', ';
}

$assignedVariableIds = substr($assignedVariableIds, 0, sizeof($assignedVariableIds) - 2);

$assignedVariableIds .= ']';

$js = <<<JS

var selectedVarIds = $assignedVariableIds;

for (var i = 0; i < selectedVarIds.length; i++) {
    $('#types-dropdown').find('[value="' + selectedVarIds[i] + '"]').prop('disabled', true); //skryjeme uz pridane premenne
}
        
$('#types-dropdown').select2();


$('#types-dropdown').change(function(){
    var fieldId = $(this).val();
    var source = $('.field-' + fieldId);


    $.get('$appendVarValueUrl?id=' + fieldId, function (data) {
        $('#dynamic-fields').append(data); //pripojime vygenerovany view do zoznamu
    });

    $('#types-dropdown').find('[value="' + fieldId + '"]').prop('disabled', true); //zneviditelnime polozku v dropdowne
    $('#types-dropdown').select2();
});

JS;
$this->registerJs($js);
?>