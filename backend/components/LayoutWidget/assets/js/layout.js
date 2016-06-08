var optionsElement;
var portalIdUrlParam = portalId ? '&portalId=' + portalId : '';
var appendUrl = {
    section: controllerUrl + '/' + 'append-section?type=' + layoutType + portalIdUrlParam,
    row: controllerUrl + '/' + 'append-row',
    block: controllerUrl + '/' + 'append-block'
};

// Event for appending new section.
$('.btn-add-section').click(function () {
    $.get(appendUrl.section, function (data) {
        var row = $('<li></li>');
        row = row.appendTo($('.sections'));
        var appendedDiv = $(data);
        $(row).append(appendedDiv);
        attachRemoveSectionEvent(row.find('.btn-remove-section'));
        attachAddRowEvent(row.find('.add-row'));
    });
});

// Event for removing section under remove button clicked.
function attachRemoveSectionEvent(removeButton) {
    removeButton.click(function () {
        $(this).parents('li').remove();
    });
}

attachRemoveSectionEvent($('.btn-remove-section')); // Remove section event attached.

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
            row = row.appendTo(sectionRows);
            var appendedDiv = $(data);
            $(row).append(appendedDiv);
            attachRemoveRowEvent(row.find('.btn-remove-row'));
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
            row = row.appendTo(blockList);
            var appendedDiv = $(data);
            $(row).append(appendedDiv);
            attachRemoveBlockEvent(row.find('.btn-remove-block'));
        });
    });
}

function appendElement(parentElement, type, wrapper) {
    var row = $('<li></li>');
    var blockList = parentElement.find('.column-elements');
    row = row.appendTo(blockList);
    var appendedDiv = $(data);
    $(row).append(appendedDiv);
    attachRemoveBlockEvent(row.find('.btn-remove-block'));
}

attachAddBlockEvent($('.column-option'));

function attachRemoveBlockEvent(removeButton) {
    removeButton.click(function () {
        $(this).parents('.layout-block').parents('li').first().remove();
    });
}

attachRemoveBlockEvent($('.btn-remove-block'));

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

// Handles elements (blocks, columns, rows) ordering.
$('#' + formId).submit(function () {
    $(".section-rows").each(function () {
        var rowOrder = 1;
        var rows = $(this).find('.layout-row');
        rows.each(function () {
            $(this).find('.order').val(rowOrder);
            rowOrder++;
            var columnOrder = 1;
            var columns = $(this).find('.column');
            columns.each(function () {
                $(this).find('.order').val(columnOrder);
                columnOrder++;
                var blocks = $(this).find('.layout-block');
                var blockOrder = 1;
                blocks.each(function () {
                    $(this).find('.order').val(blockOrder);
                    blockOrder++;
                });
            });
        });
    });
    return true;
});



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

$('.btn-block-modal').click(function () {
    var id = $(this).data('id');

    $.get('/cms/cms/backend/web/page/block?id=' + id, function (data) {
        var appendedDiv = $(data);
        $('#modal-content').append(appendedDiv);
        $('#modal-content').html = 'dasdasdasd';
    });
});


