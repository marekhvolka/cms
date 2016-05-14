$(function () {
    var menu = $(".metismenu");

    menu.find("> li > a").click(function (e) {
        var $this = $(this);
        var subitems = $this.parent().find(".in");
        if (subitems.length > 0){
            e.preventDefault();
            $this.blur();
            if (subitems.is(':visible')){
                $(this).find(".toggle").addClass("fa-angle-down").removeClass("fa-angle-up");
            } else {
                $(this).find(".toggle").removeClass("fa-angle-down").addClass("fa-angle-up");
            }

            subitems.toggle(200);
        }
    });
});