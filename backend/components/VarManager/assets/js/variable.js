for (var i = 0; i < selectedVarIds.length; i++) {
    $('#types-dropdown').find('[value="' + selectedVarIds[i] + '"]').prop('disabled', true);
}

//$('#types-dropdown').select2();

$('#types-dropdown').change(
    function () {
        var postData = {
            varId: $(this).val(),
            modelId: $(this).data('model-id'),
            prefix: $(this).data('prefix')
        };

        $.post(
            appendVarValueUrl, postData, function (data) {
                var newVariableValue = $(data);
                $('#dynamic-fields').append(newVariableValue); //pripojime vygenerovany view do zoznamu
                attachRemove(newVariableValue.find('.remove-btn').first());

                $('#types-dropdown').find('[value="' + postData.varId + '"]').prop('disabled', true); //zneviditelnime polozku
                //$('#types-dropdown').select2();
            }
        );
    }
);

function attachRemove(button) {
    $(button).click(
        function () {
            var id = $(this).data('id');

            removeItem($(this).parents('.form-group').first());

            $('#types-dropdown').find('[value="' + id + '"]').prop('disabled', false);
            $('#types-dropdown').select2();
        }
    );
}

attachRemove($('.remove-btn'));

var body = $("body");
body.on('click', ".variable-value a.open-multimedia", function (e) {
    e.preventDefault();
    var assigningTo = $(this).parents('.var-value').first().find('.value');

    Multimedia.get().show(function (path) {
        assigningTo.val(path);
    });
});

function applySpectrum() {
    var apply = $(".apply-spectrum");
    apply.find(".apply-spectrum-picker").spectrum({
        preferredFormat: "hex",
        change: function (color) {
            $(this).parents('.spectrum-parent').first().find('.source').val(color);
        }
    }).removeClass('apply-spectrum-picker');

    apply.find('.apply-spectrum-source').on('input', function () {
        var $this = $(this);
        $this.parents('.spectrum-parent').first().find('.picker').spectrum('set', $this.val());
    }).removeClass('apply-spectrum-source');

    apply.removeClass('apply-spectrum');
}

applySpectrum();