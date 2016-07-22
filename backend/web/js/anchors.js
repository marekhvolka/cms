var anchors = $(".anchors"),
    items = anchors.find('.items a'),
    search = anchors.find('input'),
    toggle = anchors.find('.toggle');

toggle.click(function (e) {
    e.preventDefault();

    anchors.toggleClass('closed');

    if (!anchors.hasClass('closed')) {
        search.focus();
    }
});

search.on('input', function () {
    items.show();

    var currVal = $(this).val().toLowerCase().trim();

    items.filter(function () {
        return $(this).text().toLowerCase().indexOf(currVal) == -1;
    }).hide();
});

items.click(function () {
    var scrollTo = $($(this).attr('href'));

    if (scrollTo.length > 0) {
        search.val('').trigger('input');
    } else {
        $(this).remove();
    }

    toggle.click();
});