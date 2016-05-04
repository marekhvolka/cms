
$('.btn-add-section').click(function(e) {
    
    
    var sectionClone = $('.cloned-section').clone();
    sectionClone.removeAttr('hidden');
    sectionClone.removeClass('cloned-section')
    $('.sections').append(sectionClone);
    
    // Attach remove button event.
    sectionClone.find('.btn-remove-section').first().click(function() {
        $(this).parents('.section').remove();
    });
    
    // Attach add row event.
    sectionClone.find('.add-row').click(function() {
        var rowClone = $('.cloned-row').clone();
        rowClone.removeClass('cloned-row');
        rowClone.removeAttr('hidden');
        
        var columnWrapper = rowClone.find('.layout-wrapper');
        columnWrapper.addClass('col-sm-12');
        
        var columnClone = $('.cloned-column').clone();
        columnClone.removeClass('cloned-column');
        columnClone.removeAttr('hidden');
        
        columnWrapper.append(columnClone);
        
        var sectionRows = sectionClone.find('.section-rows');
        sectionRows.append(rowClone);
    });
    
    return false;
});

