for (var i = 0; i < selectedVarIds.length; i++) {
    $('#types-dropdown').find('[value="' + selectedVarIds[i] + '"]').prop('disabled', true); //skryjeme uz pridane premenne
}

//$('#types-dropdown').select2();

$('#types-dropdown').change(function () {
    var fieldId = $(this).val();

    $.get(appendUrl + fieldId, function (data) {
        var newVariableValue = $(data);
        $('#dynamic-fields').append(newVariableValue); //pripojime vygenerovany view do zoznamu
        attachRemoveBtnEvent(newVariableValue.find('.remove-btn'));
    });

    $('#types-dropdown').find('[value="' + fieldId + '"]').prop('disabled', true); //zneviditelnime polozku v dropdowne
    $('#types-dropdown').select2();
});

//function attachRemove() {
//    $('.rmv-btn').click(function () {
//        var id = $(this).attr('data-field-id');
//        var elementClass = '.field-' + id + '.active-field';
//        $(elementClass).remove();
//
//        $('#types-dropdown').find('option').prop('disabled', false);
//        $('#types-dropdown').select2();
//    });
//}

function attachRemoveBtnEvent(buttons) {
    $('.remove-btn').click(function () {
        $(this).parents('.variable-value').first().remove();
        // TODO put back deleted variable to dropdown
    });
}

attachRemoveBtnEvent($('.remove-btn'));