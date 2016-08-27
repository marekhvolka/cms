$(document).ready(function() {
    var defaultItemValue = $('.toggle-switch-container .input-value').val();
    $('.toggle-switch-container .toggle-button[data-value="' + defaultItemValue + '"]').addClass('active');

    $('.toggle-switch-container .toggle-button').on('click', function() {
        $(this).parent().find('.input-value').first().val($(this).data('value'));
        $(this).find('.switch-button').removeClass('active');
        $(this).addClass('active');
    })
});
