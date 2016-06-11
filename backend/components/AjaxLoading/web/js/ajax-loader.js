$(function () {
    // before each ajax request
    $.ajaxPrefilter(function (options, _, jqXHR) {
        var timeout = setTimeout(function () {
            timeout = null;
            var ajaxLoading = $(".ajax-loading");
            ajaxLoading.stop().removeClass("hidden").css("opacity", 0).animate({"opacity": 1});
        }, 200); // so that it gets shown only after 200 seconds

        jqXHR.complete(function () {
            if (timeout != null) {
                clearTimeout(timeout); // so that the loading does not get shown
            } else {
                $(".ajax-loading").stop().css("opacity", 1).animate({"opacity": 0}, undefined, function () {
                    $(this).addClass("hidden");
                });
            }
        });
    });
});