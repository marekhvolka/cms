$( ".variable" ).each(function() {
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
        
    element.find('.attribute').each(function() {
        var name = type + '[' + hash + '][' + $(this).attr('data-attribute-name') + ']';
        $(this).attr('name', name);
    });
}

// Adding new variable.
$('.add-item-var').bind('click', function() {
    var element = $(snippetVarParams.variableHtml);  // Newly added variable.
        
    // First dymension of name attribute (array form) have to be distinctive (not to confuse server side).
    setNewHashedNamesToFields(element, 'SnippetVar'); 
    $('.container-items-vars').append(element);     // Append new variable to list of variables.
    attachSelectToListChange(element);      // Event for change to list type is attached.
    
    // Temporary id for element is created - to dynamic saving of variables tree.
    // At the time when child element is dynamic created, parent id is not created yet,
    // this substitutes id till id is created and switched in child as its parent id.
    element.find('.tmp-id').first().val(Math.random().toString(36).substring(7));    
});

// Adding new variable.
$('.add-item-code').bind('click', function() {
    attachAddItemCodeEvent();
});

function attachAddItemCodeEvent() {
    var element = $(snippetVarParams.codeHtml);  // Newly added variable.
        
    // First dymension of name attribute (array form) have to be distinctive (not to confuse server side).
    setNewHashedNamesToFields(element, 'SnippetCode'); 
    $('.container-items-codes').append(element);     // Append new variable to list of variables.
    
    // Quick bugfix for strange behavior (adding codemirror textarea to first item and cloning it)
    var codes = $('.panel-codes').first().find('.cm-s-default:not(first-child)');
    
    for (var i = 0; i < codes.length; i++) {
        if (i != 1) {
            codes[i].remove();
        }
    }
    
    var addBtn = element.find('.add-item-code');
    addBtn.click(function() {
        attachAddItemCodeEvent();
    });
    
    var textArea = element.find('textarea').first()[0];
    var editor = CodeMirror.fromTextArea(textArea, {
        lineNumbers: true
    });
    
    //TODO - this is for Select2
    var select = element.find('select').first()[0];
    select.select2({
        tags: true
    });

}

// Attachment event for changing variable type to list.
function attachSelectToListChange(element) {
    var select = element.find('select').first();
    select.change(function() {
        if($(this).val() == snippetVarParams.listId) {        // If selected type is List.
            var child = element.find('.child-var');
            child.removeAttr('hidden');

            var addChildButton = element.find('.btn-add-var');
            addChildButton.click(function() {
                var parentId = element.find('.item-id').first().val();
                if (!parentId){
                    parentId = element.find('.tmp-id').first().val();
                }
        
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
                newElement.find('.tmp-id').first().val(Math.random().toString(36).substring(7));
            });
        } else {    
            // Remove children list vars of var if there was any created.
            element.find('.child-var').first().find('ul li').remove();
            element.find('.child-var').first().attr('hidden', 'hidden');
        }
    })
}

$( ".add-item-code" ).click(function() {
    $('.container-items-codes').append();
});