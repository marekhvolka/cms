$(function () {
    var file_editor                 = $('.file-editor'),
        file_name_input             = file_editor.find('#editfileform-filename'),
        upload_file_directory_input = $("#uploadfileform-directory"),
        opened_file                 = null,
        new_file                    = false;

    function openFile(filePath, url) {
        new_file = false;
        file_editor.find('.new-file').hide();
        opened_file = filePath;
        file_editor.find('.select-a-file').hide();

        var code_mirror = $('.CodeMirror')[0].CodeMirror;

        code_mirror.setOption('readOnly', true);
        file_name_input.val(filePath);

        var extension = /(?:\.([^.]+))?$/.exec(url)[1];
        if (['png', 'jpg', 'jpeg', 'gif'].indexOf(extension.toLowerCase()) != -1) {
            file_editor.find('.file-editing').hide();
            var image = file_editor.find('.image');
            image.show();
            image.find("img").attr("src", url);
        } else {
            file_editor.find('.file-editing').show();
            file_editor.find('.image').hide();

            $.get(url, function (data) {
                code_mirror.getDoc().setValue(data);
                code_mirror.setOption("mode", 'application/x-httpd-php');
                code_mirror.setOption('readOnly', false);
            });
        }
    }

    file_editor.find('.file-link').click(function (e) {
        e.preventDefault();
        var _this = $(this);
        openFile(_this.attr('data-name'), _this.attr('href'));
    });

    $('.add-file').click(function (event) {
        event.preventDefault();
        upload_file_directory_input.val($(this).attr('data-name')).trigger("change");
    });
});