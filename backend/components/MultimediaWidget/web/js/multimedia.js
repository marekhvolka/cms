function Multimedia() {
    this.selectCallback = null;
    this.modal = null;
    this.searchInput = null;

    Multimedia.instance = this;
}

/**
 * @returns {Multimedia}
 */
Multimedia.get = function () {
    return this.instance;
};

Multimedia.prototype.init = function () {
    this.modal = $("#multimediaWidget");
    this.searchInput = $(".search-multimedia");

    var _this = this;

    $("body").on('click', '.multimedia-image', function (e) {
        e.preventDefault();
        var $this = $(this);

        if (!_this.select($this.attr('data-path-for-web'))) {
            $.fancybox.open([
                {
                    href: $this.find("img").attr('src')
                }
            ]);
        }
    });

    this.searchInput.on('change input', function () {
        var searchFor = _this.searchInput.val();

        var items = $(".multimedia-category .multimedia-item");
        items.show();
        items.each(function () {
            if (_this.searchInput.attr("data-name").indexOf(searchFor) == -1) {
                _this.searchInput.hide();
            }
        });

        var categories = $(".multimedia-category");
        categories.show();
        categories.each(function () {
            if (_this.searchInput.find(".multimedia-item:visible").length == 0) {
                _this.searchInput.hide();
            }
        });
    });

    var $form = $("#upload-file-multimedia"),
        sendData = function (e) {
            e.preventDefault();

            if ($form.find('.has-error').length) {
                return false;
            }

            var formData = new FormData(),
                files = $("input[name='MultimediaItem[files]']")[1].files;

            if (files.length > 0) {

                formData.append("MultimediaItem[path]", $(".select-path").val());
                $.each(files, function (i, item) {
                    formData.append("MultimediaItem[files][]", item);
                });

                $.ajax({
                    url: multimediaUploadURL,
                    type: 'POST',

                    // Form data
                    data: formData,

                    success: function (response) {
                        if (response.state == "ok") {
                            _this.refresh();
                            if (!_this.select(response.pathForWeb + "/" + files[0].name)) {
                                $('.multimedia-widget .nav-tabs a:last').tab('show');
                            }
                            $("#multimediaitem-files").fileinput('reset');
                        }
                    },

                    error: function () {
                        alert('Nepodarilo sa nahrať súbor.');
                    },


                    //Options to tell jQuery not to process data or worry about content-type.
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        };

    $(".save-multimedia").on('click', sendData);
    $form.on('submit', sendData);
};

Multimedia.prototype.show = function (callbackForSelect) {
    this.selectCallback = callbackForSelect;
    this.modal.modal("show");
};

Multimedia.prototype.refresh = function () {
    var _this = this;
    $.get(multimediaRefreshURL, function (data) {
        var list = $(".multimedia-categories");
        list.empty();
        list.append($(data));
        _this.searchInput.val();
    });
};

Multimedia.prototype.select = function (path) {
    if (typeof this.selectCallback === 'function') {
        this.selectCallback(path);

        this.modal.modal("hide");

        return true;
    } else {
        return false;
    }
};

$(function () {
     new Multimedia().init();
});