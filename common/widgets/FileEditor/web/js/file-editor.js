$(function () {
    var file_editor                 = $('.file-editor'),
        code_mirror                 = $('.CodeMirror')[0].CodeMirror,
        file_name_input             = file_editor.find('#editfileform-filename'),
        upload_file_directory_input = $("#uploadFileDirectory"),
        opened_file                 = null,
        new_file                    = false;

    function openFile(filePath, url) {
        new_file = false;
        file_editor.find('.new-file').hide();
        opened_file = filePath;
        file_editor.find('.select-a-file').hide();

        code_mirror.setOption('readOnly', true);
        file_name_input.val(filePath);

        $.get(url, function (data) {
            code_mirror.getDoc().setValue(data);
            code_mirror.setOption("mode", 'application/x-httpd-php');
            code_mirror.setOption('readOnly', false);
        });
    }

    file_editor.find('.file-link').click(function (e) {
        e.preventDefault();
        var _this = $(this);
        openFile(_this.attr('data-name'), _this.attr('href'));
    });

    $('.add-file').click(function (event) {
        event.preventDefault();
        upload_file_directory_input.val($(this).attr('data-name'));
    });
});