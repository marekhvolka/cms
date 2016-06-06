$(function () {
    var file_editor = $('.file-editor');

    /**
     * Opens a file in the editor. In case of an image, shows not the textarea but the image itself.
     *
     * @param filePath the path to the file
     * @param url the url containing the file (will be called by AJAX to acquire the content of the file)
     */
    function openFile(filePath, url) {
        file_editor.find('.select-a-file').hide();

        var code_mirror = $('.CodeMirror')[0].CodeMirror;

        // disable editing during loading the file
        code_mirror.setOption('readOnly', true);
        // set the hidden input's value determining the path to the file to the file which should be opened
        file_editor.find('#editfileform-filename').val(filePath);

        var extension = /(?:\.([^.]+))?$/.exec(url)[1];
        // is the file an image?
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
                code_mirror.setOption('readOnly', false);
            });
        }
    }

    // open file
    file_editor.find('.file-link').click(function (e) {
        e.preventDefault();
        var _this = $(this);
        openFile(_this.attr('data-name'), _this.attr('href'));
    });

    // add file to a directory
    $('.add-file').click(function (event) {
        event.preventDefault();
        // set the directory to be predefined in the input
        $("#uploadfileform-directory").val($(this).attr('data-name')).trigger("change");
    });
});