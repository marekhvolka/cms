$(function () {
    var file_editor = $('.file-editor');

    /**
     * Opens a file in the editor. In case of an image, shows not the textarea but the image itself.
     *
     * @param name the name of the file
     * @param directory the directory of the file
     * @param url the url containing the file (will be called by AJAX to acquire the content of the file)
     */
    function openFile(name, directory, url) {
        file_editor.find('.select-a-file').hide();

        var code_mirror = $('.CodeMirror')[0].CodeMirror;

        // disable editing during loading the file
        code_mirror.setOption('readOnly', true);
        // set the hidden input's value determining the path to the file to the file which should be opened
        file_editor.find('#editfileform-name').val(name);
        file_editor.find('#editfileform-directory').val(directory);

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
                var url = $("#url");
                file_editor.find('.file-name').text(name);
                if (url.is('[data-remove-extension]')) {
                    name = name.replace(/\.[^/.]+$/, "");
                }
                url.val(url.attr('data-prefix') + directory + "/" + name);
                code_mirror.getDoc().setValue(data);
                code_mirror.setOption('readOnly', false);
                code_mirror.refresh();
            });
        }
    }

    // open file
    file_editor.find('.file-link').click(function (e) {
        e.preventDefault();
        var _this = $(this);
        openFile(_this.attr('data-name'), _this.attr('data-directory'), _this.attr('href'));
    });

    // confirmation of deleting
    file_editor.find(".delete").click(function (e) {
        if (!window.confirm("Skutočne chcete zmazať '" + $(this).attr("data-path") + "'?")) {
            e.preventDefault();
        }
    });

    // add file to a directory
    $('.add-file').click(function (event) {
        event.preventDefault();
        // set the directory to be predefined in the input
        $("#uploadfileform-directory").val($(this).attr('data-name')).trigger("change");
    });

    $("*[data-target='#createFileModal']").click(function () {
        setTimeout(function () {
            $('#createFileModal .CodeMirror')[0].CodeMirror.refresh();
        }, 400);
    });

    new Clipboard('.clippy');

    $(".clippy").click(function (e) {
        e.preventDefault();
    });

    $("#url").on("keydown keypress keyup paste", function (e) {
        if (e.keyCode == null || e.keyCode == undefined) {
            e.preventDefault();
        } else if (!e.ctrlKey && !e.shiftKey && !e.altKey && !e.metaKey && (((36 < e.keyCode && e.keyCode < 41) || // arrows
            (44 < e.keyCode && e.keyCode < 47) || // insert, delete
            (47 < e.keyCode && e.keyCode < 58) || // numbers
            (64 < e.keyCode && e.keyCode < 91) || // letters
            (95 < e.keyCode && e.keyCode < 108) || // numpads, multiply, add
            (108 < e.keyCode && e.keyCode < 112) || // subtract, decimal point, divide
            (185 < e.keyCode && e.keyCode < 193) || // semi-colon, equal sign, comma, dash, period, forward slash, grave accent
            (218 < e.keyCode && e.keyCode < 223) || // open bracket, back slash, close bracket, single quote
            e.keyCode == 113 || // F2
            e.keyCode == 13 || // enter
            e.keyCode == 32 || // space
            e.keyCode == 8))) {
            e.preventDefault();
        }
    });
});