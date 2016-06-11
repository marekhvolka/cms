$(function () {
    $(".tree-grid .toggle").click(function (e) {
        e.preventDefault();

        var _this = $(this);
        _this.parents(".level").first().find(".level").slideToggle(400);
        var icon = _this.find(".fa");
        icon.toggleClass("fa-angle-up");
        icon.toggleClass("fa-angle-down");
    });
});