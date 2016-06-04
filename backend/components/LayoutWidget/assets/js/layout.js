var optionsElement;
var appendUrl = {
    section: controllerUrl + '/' + 'append-section?type=' + layoutType,
    row: controllerUrl + '/' + 'append-row',
    block: controllerUrl + '/' + 'append-block',
}

$('.btn-add-section').click(function () {
    $.get(appendUrl.section, function (data) {
        var row = $('<li></li>');
        var row = row.appendTo($('.sections'));
        var appendedDiv = $(data);
        $(row).append(appendedDiv);
        attachRemoveSectionEvent(row.find('.btn-remove-section'));
        attachAddRowEvent(row.find('.add-row'));
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

function attachAddRowEvent(button) {
    button.click(function () {
        var columnsByWidth = getColumnsWidths($(this).data('row-type-width'));
        var section = $(this).parents('.section').first();
        var sectionId = section.find('.id').first().val();

        $.post(appendUrl.row, {columns: columnsByWidth, sectionId: sectionId}, function (data) {
            var sectionRows = section.find('.section-rows');
            var row = $('<li></li>');
            var row = row.appendTo(sectionRows);
            var appendedDiv = $(data);
            $(row).append(appendedDiv);
            attachRemoveSectionEvent(row.find('.btn-remove-row'));
            attachAddBlockEvent(row.find('.column-option'));
        });
    });
}

attachAddRowEvent($('.add-row'));

function attachAddBlockEvent(button) { 
    button.click(function () {
        var column = $(this).parents('.column').first();
        var columnId = column.find('.id').first().val();
        
        $.get(appendUrl.block + '?id=' + columnId, function (data) {
            var row = $('<li></li>');
            var blockList = column.find('.column-elements');
            var row = row.appendTo(blockList);
            var appendedDiv = $(data);
            $(row).append(appendedDiv);
            attachRemoveBlockEvent(row.find('.btn-remove-block'));
        });
    });
}

attachAddBlockEvent($('.column-option'));

function attachRemoveBlockEvent(removeButton) {
    removeButton.click(function () {
        $(this).parents('.layout-block').parents('li').first().remove();
    });
}

attachRemoveBlockEvent($('.btn-remove-block'));













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


