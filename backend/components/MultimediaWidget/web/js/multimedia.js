$(function () {
    $("body").on('click', '.multimedia-image', function (e) {
        e.preventDefault();
        var $this = $(this);

        if (!select($this.attr('data-path-for-web'))) {
            $.fancybox.open([
                {
                    href: $this.find("img").attr('src')
                }
            ]);
        }
    });

    var $searchInput = $(".search-multimedia");
    $searchInput.on('change input', function () {
        var searchFor = $(this).val();

        var items = $(".multimedia-category .multimedia-item");
        items.show();
        items.each(function () {
            if ($(this).attr("data-name").indexOf(searchFor) == -1) {
                $(this).hide();
            }
        });

        var categories = $(".multimedia-category");
        categories.show();
        categories.each(function () {
            var $this = $(this);
            if ($this.find(".multimedia-item:visible").length == 0) {
                $this.hide();
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
                            refreshMultimedia();
                            if (!select(response.pathForWeb + "/" + files[0].name)){
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

    function refreshMultimedia() {
        $.get(multimediaRefreshURL, function (data) {
            var list = $(".multimedia-categories");
            list.empty();
            list.append($(data));
            $searchInput.val();
        });
    }

    function select(path) {
        var multimediaSelect = getMultimediaSelectCallback();
        if (typeof multimediaSelect === 'function') {
            multimediaSelect(path);

            $("#multimediaWidget").modal("hide");

            return true;
        } else {
            return false;
        }
    }

    $(".save-multimedia").on('click', sendData);
    $form.on('submit', sendData);
})
;