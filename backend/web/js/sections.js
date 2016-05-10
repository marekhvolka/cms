var optionsElement;

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
        var row = $('<li class="row"></li>');
        
        var columns = getRowColumnsClasses($(this).data('row-type-width'));
        for (var i = 0; i < columns.length; i++) {
            var columnWrapper = $('<div class="column-wrapper col-sm-' + columns[i] + '"></div>').appendTo(row);
            var columnClone = $('.cloned-column').clone();
            
            columnClone.removeClass('cloned-column');
            columnClone.removeAttr('hidden');

            columnWrapper.append(columnClone);
            
            // Remove row event attached.
            columnClone.find('.btn-remove-row').click(function() {
                $(this).parents('.row').first().remove();
            })    
            
            attachOptionsButtonEvent(columnClone.find('.options-btn'));
        }
        
        var sectionRows = sectionClone.find('.section-rows');
        sectionRows.append(row);
        
        $('.section-rows').sortable('reload');  // Attach event for sorting sections.
    });
    
    attachOptionsButtonEvent(sectionClone.find('.options-btn'));
    
    $('.sections').sortable('reload');  // Attach event for sorting sections.
    return false;
});

function attachOptionsButtonEvent(button) {
    button.click(function(){
        var jsonStringOptions = $(this).parents('.panel').first().attr('data-options');
        var options = JSON.parse(jsonStringOptions);
        if (!$.isEmptyObject(options)) {
            $('#options').find('[name="section-id"]').val(options.id);
            $('#options').find('[name="section-class"]').val(options.class);
            $('#options').find('[name="section-style"]').val(options.style);
//            $('#options').find('[name="section-id"]').val('dasd');
//            $('#options').find('[name="section-class"]').val('2w');
//            $('#options').find('[name="section-style"]').val('uyyydyy');
        }
        
        optionsElement = $(this).parents('.panel').first();
    });
}

$('.btn-save-options').click(function(){
    var options = {};
    options.id = $('#options').find('[name="section-id"]').val();
    options.class = $('#options').find('[name="section-class"]').val();
    options.style = $('#options').find('[name="section-style"]').val();
    
    var optionsJson = JSON.stringify(options);
    optionsElement.attr('data-options', optionsJson);
    
    clearOptions();
    
    return true;
});

$('#modal-options').on('hidden.bs.modal', function () {
    clearOptions();
});

function clearOptions() {
    $('#options').find('[name="section-id"]').val('');
    $('#options').find('[name="section-class"]').val('');
    $('#options').find('[name="section-style"]').val('');
}

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
