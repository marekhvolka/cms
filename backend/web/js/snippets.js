
$( ".variable" ).each(function() {
    attachSelectToListChange($(this));
});
        
// Getting HTML code for single variable.
$.get(snippetVarParams.appendVarUrl, function (data) {
    snippetVarParams.variableCode = data;
});
        
function setNewHashedNamesToFields(element) {   //TODO may be refactored simplier.
    var hash = Math.random().toString(36).substring(7);
        
    element.find('.attribute').each(function() {
        $(this).attr('name', 'SnippetVar[' + hash + '][' + $(this).attr('data-attribute-name') + ']');
    });
}

// Adding new variable.
$('.add-item-vars ').bind('click', function() {
    var element = $(snippetVarParams.variableCode);  // Newly added variable.
        
    // First dymension of name attribute (array form) have to be distinctive (not to confuse server side).
    setNewHashedNamesToFields(element); 
    $('.container-items-vars').append(element);     // Append new variable to list of variables.
    attachSelectToListChange(element);      // Event for change to list type is attached.
    
    // Temporary id for element is created - to dynamic saving of variables tree.
    // At the time when child element is dynamic created, parent id is not created yet,
    // this substitutes id till id is created and switched in child as its parent id.
    element.find('.tmp-id').first().val(Math.random().toString(36).substring(7));    
});
        
function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
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
                
                var newElement = $(snippetVarParams.variableCode);
                listElement.append(newElement);
        
                setNewHashedNamesToFields(newElement);
                
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
