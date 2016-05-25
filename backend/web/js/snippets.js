function attachAddItemCodeEvent(addButton) {
    addButton.click(function () {
        $.get(snippetVarParams.appendCodeUrl, function (data) {
            var row = $('<li></li>');
            var row = row.appendTo($('.container-items-codes'));
            var appendedDiv = $(data);
            $(row).append(appendedDiv);
            attachAddItemCodeEvent(appendedDiv.find('.add-item-code'));
            attachRemoveCodeEvent(appendedDiv.find('.remove-item-code'));
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

attachAddItemCodeEvent($('.add-item-code'));
attachRemoveCodeEvent($('.remove-item-code'));






// Attachment event for changing variable type to list.
function attachSelectToListChange(element) {
    var select = element.find('select').first();
    
    select.change(function () {
        if ($(this).val() == snippetVarParams.listId) {        // If selected type is List.
            
            var child = element.find('.child-var');
            child.removeAttr('hidden');

            var addChildButton = element.find('.btn-add-var');
            addChildButton.click(function () {
                var parentId = element.find('.item-id').first().val();

                var varList = child.find('ul').first();
                var countOfListElements = varList.find('li').length;
                console.log(countOfListElements);

                var listElement = $('<li></li>');
                varList.append(listElement);

                var newElement = $(snippetVarParams.variableHtml);
                listElement.append(newElement);

                setNewHashedNamesToFields(newElement, 'SnippetVar');

                attachSelectToListChange(newElement);
                newElement.find('.parent-id').first().val(parentId);
                newElement.find('.item-id').first().val(Math.random().toString(36).substring(7));
            });
        } else {
            // Remove children list vars of var if there was any created.
            element.find('.child-var').first().find('ul li').remove();
            element.find('.child-var').first().attr('hidden', 'hidden');
        }
    })
}

$(".snippet-var").each(function () {
    attachSelectToListChange($(this));
});

// Getting HTML code for single variable.
$.get(snippetVarParams.appendVarUrl, function (data) {
    snippetVarParams.variableHtml = data;
});

// Getting HTML code for single code.
$.get(snippetVarParams.appendCodeUrl, function (data) {
    snippetVarParams.codeHtml = data;
});

function setNewHashedNamesToFields(element, type) {   //TODO may be refactored simplier.
    var hash = Math.random().toString(36).substring(7);

    element.find('.attribute').each(function () {
        var name = type + '[' + hash + '][' + $(this).attr('data-attribute-name') + ']';
        $(this).attr('name', name);
    });
}

// Adding new variable.
$('.add-item-var').bind('click', function () {
    var element = $(snippetVarParams.variableHtml);  // Newly added variable.

    // First dimension of name attribute (array form) have to be distinctive (not to confuse server side).
    setNewHashedNamesToFields(element, 'SnippetVar');
    $('.container-items-vars').append(element);     // Append new variable to list of variables.
    attachSelectToListChange(element);      // Event for change to list type is attached.

    // Temporary id for element is created - to dynamic saving of variables tree.
    // At the time when child element is dynamic created, parent id is not created yet,
    // this substitutes id till id is created and switched in child as its parent id.
    element.find('.item-id').first().val(Math.random().toString(36).substring(7));
});




$(".add-item-code").click(function () {
    $('.container-items-codes').append();
});