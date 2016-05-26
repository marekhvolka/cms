function attachAddCodeEvent(addButton) {
    addButton.click(function () {
        $.get(snippetVarParams.appendCodeUrl, function (data) {
            var row = $('<li></li>');
            var row = row.appendTo($('.snippet-codes'));
            var appendedDiv = $(data);
            $(row).append(appendedDiv);
            attachAddCodeEvent(appendedDiv.find('.btn-add-snippet-code'));
            attachRemoveCodeEvent(appendedDiv.find('.btn-remove-snippet-code'));
        });
    });
}

function attachRemoveCodeEvent(removeButton) {
    removeButton.click(function () {
        if ($('.snippet-code').length <= 1) {
            return;
        }
        $(this).parents('li').remove();
    });
}

attachAddCodeEvent($('.btn-add-snippet-code'));
attachRemoveCodeEvent($('.btn-remove-snippet-code'));

function attachAddVarEvent(addButton, varWrapper, parent) {
    // Adding new variable.
    addButton.click(function () {
        var url = snippetVarParams.appendVarUrl;
        if (parent) {
            var parentId = parent.find('.variable-id').val();
            url += '?id=' + parentId;
        }
        
        $.get(url, function (data) {
            var row = $('<li></li>');
            var row = row.appendTo(varWrapper);
            var appendedDiv = $(data);
            $(row).append(appendedDiv);
            attachRemoveVarEvent(appendedDiv.find('.btn-remove-snippet-var'));
            attachSelectToListChangeEvent(appendedDiv);
        });
    });
}

function attachRemoveVarEvent(removeButton) {
    removeButton.click(function () {
        $(this).parents('li').first().remove();
    });
}

attachRemoveVarEvent($('.btn-remove-snippet-var'));
attachAddVarEvent($('.btn-add-snippet-var'), $('.snippet-vars'), null);

// Attachment event for changing variable type to list.
function attachSelectToListChangeEvent(variable) {
    var select = variable.find('select').first();

    select.change(function () {
        if ($(this).val() == snippetVarParams.listId) {        // If selected type is List.
            $.get(snippetVarParams.appendChildVarBox, function (data) {
                var varBodyWrapper = variable.find('.var-body');
                var appended = $(data).appendTo(varBodyWrapper);
                attachAddVarEvent(appended.find('.btn-add-list-item-var'), varBodyWrapper.find('.snippet-vars'), variable);
            });
        }
    });
}

$(".snippet-var").each(function () {
    attachSelectToListChangeEvent($(this));
});

