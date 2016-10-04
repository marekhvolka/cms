$(document).ready(
    function () {
        $("input[data-check='switch']").bootstrapSwitch();

        var url = document.location.toString();
        if (url.match('#')) {
            $('.custom-tabs .tab-label').removeClass('active'); //zrusime aktualny tab
            $('.custom-tab-content > .tab-pane').hide();

            var bookmarkId = url.split('#')[1];

            $('.custom-tabs a[href="#' + bookmarkId + '"]').parent().addClass('active'); //ak sa najde tab s danou kotvou, tak ho
                                                                                      // dame ako aktivny
            $('.custom-tab-content > .tab-pane#' + bookmarkId).show();

            var bookmarkedElement = $('#' + bookmarkId).first();

            var parentTabPane = bookmarkedElement.closest('.tab-pane'); //pre pripad, ze sa kotva nachadza v tabe,
                                                                                  // musime odkryt aj tab, v ktorom sa nachadza
            if (typeof parentTabPane != 'undefined') {
                parentTabPane.show();
                $('.custom-tabs a[href="#' + parentTabPane.attr('id') + '"]').parent().addClass('active');

                bookmarkedElement.parent().scrollTop = 0;
            }
        }

        $("body").on(
            'click', '.panel-heading .collapse-btn', function () {
                $(this).parents('.panel').first().find('.panel-body').first().collapse('toggle');
            }
        );

        $(".custom-tabs a").click(function() { //skryvanie a odkryvanie po kliknuti
            $( ".custom-tab-content > div[id^='tab']").hide(); //skryjeme vsetky taby

            var targetId = $(this).attr('href');
            $(targetId).show();
        });
    }
);

function initializeMultimediaBtn() {
    $('body').on('click', ".input-group a.open-multimedia", function (e) {
        e.preventDefault();
        var assigningTo = $(this).parents('.input-group').first().find('.value');

        Multimedia.get().show(function (path) {
            assigningTo.val(path);
        });
    });
}

initializeMultimediaBtn();

$('form:not(.disable-are-you-sure)').areYouSure();

function rescanForms() {
    $('form:not(.disable-are-you-sure)').trigger('rescan.areYouSure');
}

function removeItem(item) {
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
 });

 */