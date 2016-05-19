
function attachRemove() {
    $('.rmv-btn').click(function () {
        var id = $(this).attr('data-field-id');
        var elementClass = '.field-' + id + '.active-field';
        $(elementClass).remove();

        $('#types-dropdown').find('option').prop('disabled', false);
        $('#types-dropdown').select2();
    });
}
