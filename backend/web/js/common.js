$(document).ready(function() {
    $('#radioBtn').each(function() {

    });
});

$('#radioBtn a').on('click', function(){
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#'+tog).prop('value', sel);

    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
});

$("body").on(
    'click', '.panel-heading .collapse-btn', function ()
    {
        $(this).parents('.panel').first().find('.panel-body').first().collapse('toggle');
    }
);

function enableDragBy(items, dragBy) {
    dragula(items, {
        moves: function (el, container, handle) {
            return dragBy == null || $(handle).is(dragBy);
        },
        accepts: function (el, target, source, sibling) {
            return target == source;
        },
        invalid: function () {
            return disableDragAndDrop;
        }
    });
}