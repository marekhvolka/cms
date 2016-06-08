$(function () {
    $(".image-multimedia").click(function (e) {
        e.preventDefault();

        $.fancybox.open([
            {
                href: $(this).attr('href')
            }
        ]);
    });

    $("select[name='subcategory']").change(function (e) {
        var newSubcategory = $(this).val();
        var newUrl = window.location.href;
        if (newUrl.indexOf('subcategory') == -1){
            if (newUrl.indexOf('?') == -1){
                newUrl += "?";
            } else {
                newUrl += "&";
            }

            newUrl += "subcategory=" +  encodeURI(newSubcategory);
        }

        window.location.href = newUrl.replace(/(subcategory=[^&]*)/, 'subcategory=' + encodeURI(newSubcategory));
    })
});