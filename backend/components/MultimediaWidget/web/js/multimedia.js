$(function () {
    $(".multimedia-item img").click(function (e) {
        e.preventDefault();

        $.fancybox.open([
            {
                href: $(this).attr('src')
            }
        ]);
    });

    $(".search-multimedia").on('change input', function () {
        var searchFor = $(this).val();

        var items = $(".multimedia-category .multimedia-item");
        items.show();
        items.each(function () {
            if ($(this).attr("data-name").indexOf(searchFor) == -1) {
                $(this).hide();
            }
        });
    });
});