CKEDITOR.dialog.add('custimageDialog', function (editor) {
    return {
        title: 'Image Properties',
        minWidth: 400,
        minHeight: 200,
        contents: [{
            id: 'tab-basic',
            label: 'Basic Settings',
            elements: [{
                type: 'text',
                id: 'src',
                label: 'Source',
                validate: CKEDITOR.dialog.validate.notEmpty("Image source field cannot be empty")
            }, {type: 'text', id: 'alt', label: 'Alternative'}]
        }],
        onShow: function () {
            showMultimedia(function (url) {
                var custimage = editor.document.createElement('img');
                custimage.setAttribute('src', url);
                custimage.setAttribute('alt', url);
                editor.insertElement(custimage);
            });
            CKEDITOR.dialog.getCurrent().hide();
        },
        onOk: function () {
            var dialog = this;
            var custimage = editor.document.createElement('img');
            custimage.setAttribute('src', dialog.getValueOf('tab-basic', 'src'));
            custimage.setAttribute('alt', dialog.getValueOf('tab-basic', 'alt'));
            editor.insertElement(custimage)
        }
    }
});