$(document).ready(function() {
    var defaultItemValue = $('.multiple-switch-container .input-value').val();
    $('.multiple-switch-container .switch-button[data-value="' + defaultItemValue + '"]').addClass('active');
    
    $('.multiple-switch-container .switch-button').on('click', function() {
        $(this).parent().find('.input-value').first().val($(this).data('value'));
        $(this).find('.switch-button').removeClass('active');
        $(this).addClass('active');
    })
});
