
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
        
        var columns = getRowColumnsClasses($(this).data('row-type-width'));
        for (var i = 0; i < columns.length; i++) {
            var columnWrapper = $('<div class="column-wrapper col-sm-' + columns[i] + '"></div>').appendTo(rowClone);
            var columnClone = $('.cloned-column').clone();
            
            columnClone.removeClass('cloned-column');
            columnClone.removeAttr('hidden');

            columnWrapper.append(columnClone);
            
            // Remove row event attached.
            columnClone.find('.btn-remove-row').click(function() {
                $(this).parents('.row').first().remove();
            })    
        }
        
        var sectionRows = sectionClone.find('.section-rows');
        sectionRows.append(rowClone);
    });
    
    return false;
});





function getRowColumnsClasses(rowType) {
    switch (rowType) {
        case 1:
            return ['12'];
        case 2:
            return ['6', '6'];
        case 3:
            return ['4', '4', '4'];
        case 4:
            return ['3', '3', '3', '3'];
        case '2/1':
            return ['8', '4'];
        case '1/2':
            return ['4', '8'];
    }
}
