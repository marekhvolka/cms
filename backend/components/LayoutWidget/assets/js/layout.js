var optionsElement;
var appendUrl = {
    section: controllerUrl + '/' + 'append-section',
    row: controllerUrl + '/' + 'append-row',
}

$('.btn-add-section').click(function () {
    $.get(appendUrl.section, function (data) {
        var row = $('<li></li>');
        var row = row.appendTo($('.sections'));
        var appendedDiv = $(data);
        $(row).append(appendedDiv);
        attachRemoveSectionEvent(row.find('.btn-remove-section'));
    });
});

function attachRemoveSectionEvent(removeButton) {
    removeButton.click(function () {
        $(this).parents('li').remove();
    });
}

attachRemoveSectionEvent($('.btn-remove-section'));

function attachRemoveRowEvent(removeButton) {
    removeButton.click(function () {
        $(this).parents('.layout-row').parents('li').first().remove();
    });
}

attachRemoveRowEvent($('.btn-remove-row'));




$('.add-row').click(function () {
    var columnsByWidth = getColumnsWidths($(this).data('row-type-width'));
    var section = $(this).parents('.section').first();
    var sectionId = section.find('.id').val();
    
    $.post(appendUrl.row, {columns : columnsByWidth, sectionId: sectionId}, function (data) {
        var sectionRows = section.find('.section-rows');
        var row = $('<li></li>');
        var row = row.appendTo(sectionRows);
        var appendedDiv = $(data);
        $(row).append(appendedDiv);
        attachRemoveSectionEvent(row.find('.btn-remove-row'));
    });
});


//$.get(snippetVarParams.appendVarUrl, function (data) {
//    snippetVarParams.variableHtml = data;
//});
//
//$('#save-btn').click(function () {
//    var data = prepareData();
//    $.post(pageParams.url, {data: data}, function (result) {
//        console.log(result);
//    });
//});
//
//function prepareData() {
//    // Loop trhough Sections.
//    var sections = $('.section');
//    sections.each(function() {
//        
//        //$(this)
//    });
//}


$('.btn-add-section2').click(function (e) {
    var sectionClone = $('.section.cloned').first().clone();
    sectionClone.removeClass('cloned');
    var sectionsId = $(this).data('sections-id');
    $('#sections-' + sectionsId).append(sectionClone);
    
    // Attach remove button event.
    sectionClone.find('.btn-remove-section').first().click(function () {
        $(this).parents('.section').remove();
    });

    // Add row.
    sectionClone.find('.add-row').click(function (e) {
        var row = $('<li></li>');
        var sectionRows = sectionClone.find('.section-rows');
        row = row.appendTo(sectionRows);
        var rowClone = $('.layout-row.cloned').first().clone();
        rowClone.removeClass('cloned');
        row = rowClone.appendTo(row);

        var columnsByWidth = getColumnsWidths($(this).data('row-type-width'));

        // Add column.
        for (var i = 0; i < columnsByWidth.length; i++) {
            var columnClone = $('.column.cloned').first().clone();
            columnClone.addClass('col-md-' + columnsByWidth[i]);

            columnClone.removeClass('cloned');
            row.append(columnClone);

            // Remove row event attached.
            columnClone.find('.btn-remove-row').click(function () {
                $(this).parents('.row').first().remove();
            });

            //attachOptionsButtonEvent(columnClone.find('.options-btn'));
        }

    });

    attachOptionsButtonEvent(sectionClone.find('.options-btn'));
});


function attachOptionsButtonEvent(button) {
    button.click(function () {
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

$('.btn-save-options').click(function () {
    var options = {};
    options.id = $('#options').find('[name="section-id"]').val();
    options.class = $('#options').find('[name="section-class"]').val();
    options.style = $('#options').find('[name="section-style"]').val();

    var optionsJson = JSON.stringify(options);
    optionsElement.attr('data-options', optionsJson);

    return true;
});


function clearOptions() {
    $('#options').find('[name="section-id"]').val('');
    $('#options').find('[name="section-class"]').val('');
    $('#options').find('[name="section-style"]').val('');
}

function getColumnsWidths(rowType) {
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

// Clearing modal window.
$(function () {
    $('#modal-options').on('hidden.bs.modal', function () {
        clearOptions();
    });
});

$(function () {
    $('#modal-text').on('hidden.bs.modal', function () {
        $('.text-textarea').val('');
    });
});


