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

    var $form = $("#upload-file-multimedia"),
        first = false;
    $form.submit(function (e) {
        if (!first) {
            first = true;
            return;
        }
        e.preventDefault();

        if ($form.find('.has-error').length) {
            return false;
        }

        var formData = new FormData($(this)[0]);

        $.ajax({
            url: multimediaUploadURL,
            type: 'POST',

            // Form data
            data: formData,

            success: function (response) {
                if (response.state == "ok") {
                    $("#multimediaitem-files").fileinput('reset');
                    alert("Nahrané");
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
    });
});