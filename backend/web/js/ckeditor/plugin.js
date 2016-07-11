CKEDITOR.plugins.add('custimage', {
    init: function (editor) {
        editor.addCommand('custimage', new CKEDITOR.dialogCommand('custimageDialog'));
        editor.ui.addButton('custimage', {label: editor.lang.common.image, command: 'custimage', toolbar: 'insert', icon: location.protocol + "//" + location.host + '/backend/web/js/ckeditor/icons/custimage.png'});
    }
});