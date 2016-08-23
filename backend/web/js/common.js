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

var disableDragAndDrop = false;

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

$('form:not(.disable-are-you-sure)').areYouSure();

function rescanForms() {
    $('form:not(.disable-are-you-sure)').trigger('rescan.areYouSure');
}

function removeItem(item)
{
    item.addClass('hidden');
    item.find('.removed').first().val(1);
}
/*
$('form').on('beforeSubmit', function(e) {
    var form = $(this).clone();

    if ($(document.activeElement).attr('name') != 'continue') {
        return true;
    }

    var element = $(document.createElement('input')).attr('name', 'ajaxSubmit').val(1).addClass('hidden');
    form.append(element);

    $.post(
        form.attr('action'),
        form.serialize()
    ).done(function(result) {

        resultObject = JSON.parse(result);
        if (resultObject.status == 'success') {
            $('#page-wrapper').prepend(resultObject.message);
        } else {
            $(form).trigger('reset');
        }
    }).fail(function() {
        console.log('server error');
    });
    return false;
});*/

var url = document.location.toString();
if (url.match('#')) {

    $('.nav-tabs .tab-label').removeClass('active');
    $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').parent().addClass('active');
    $('.tab-content .tab-pane').hide();
    $('.tab-content .tab-pane#' + url.split('#')[1]).show();
}