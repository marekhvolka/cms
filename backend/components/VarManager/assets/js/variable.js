for (var i = 0; i < selectedVarIds.length; i++)
{
    $('#types-dropdown').find('[value="' + selectedVarIds[i] + '"]').prop('disabled', true);
}

//$('#types-dropdown').select2();

$('#types-dropdown').change(
    function ()
    {
        var postData = {
            varId: $(this).val(),
            modelId: $(this).data('model-id'),
            prefix: $(this).data('prefix')
        };

        $.post(
            appendUrl, postData, function (data)
            {
                var newVariableValue = $(data);
                $('#dynamic-fields').append(newVariableValue); //pripojime vygenerovany view do zoznamu
                attachRemove(newVariableValue.find('.remove-btn').first());

                $('#types-dropdown').find('[value="' + postData.varId + '"]').prop('disabled', true); //zneviditelnime polozku
                //$('#types-dropdown').select2();
            }
        );
    }
);

function attachRemove(button)
{
    $(button).click(
        function ()
        {
            var id = $(this).data('id');
            $(this).parents('.form-group').first().remove();

            $('#types-dropdown').find('[value="' + id + '"]').prop('disabled', false);
            $('#types-dropdown').select2();
        }
    );
}

attachRemove($('.remove-btn'));

var assigningTo = null;

$("body").on('click', ".variable-value a[data-target='#multimediaWidget']", function () {
     assigningTo = $(this).parents('.var-value').first().find('.value');
});

function assignMultimediaItemToVariable(path) {
    assigningTo.val(path);
}