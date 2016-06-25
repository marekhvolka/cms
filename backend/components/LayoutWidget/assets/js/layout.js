var appendUrl = {
    section: controllerUrl + '/' + 'append-section',
    row: controllerUrl + '/' + 'append-row',
    column: controllerUrl + '/' + 'append-columns',
    block: controllerUrl + '/' + 'append-block',
    blockModal: controllerUrl + '/' + 'append-block-modal'
};

// Event for appending new section.
$('.btn-add-section').click(function () {
    var layouts = $(this).parents('.layouts');
    var postData = {
        type : layoutType,
        prefix : $(this).data('prefix')
    };

    $.post(appendUrl.section, postData, function (data) {
        var row = appendElement(layouts, $(data));
        attachRemoveSectionEvent(row.find('.btn-remove-section'));
        attachAddRowEvent(row.find('.add-row'));
    });
});

// Event for removing section under remove button clicked.
function attachRemoveSectionEvent(removeButton) {
    removeButton.click(function () {
        $(this).parents('.section').remove();
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

        var postData = {
            prefix : $(this).data('prefix')
        };

        $.post(appendUrl.row, postData, function (data) {
            var row = appendElement(section, $(data));
            attachRemoveRowEvent(row.find('.btn-remove-row'));

            var postColumnData = {
                width : columnsByWidth,
                prefix : row.data('prefix')
            };

            $.post(appendUrl.column, postColumnData, function (columnsData) {

                var columnsArray = JSON.parse(columnsData);

                for(var i = 0; i < columnsArray.length; i++)
                    var column = appendElement(row, $(columnsArray[i]));
            });

            attachAddBlockEvent(row.find('.column-option'));
        });
    });
}

attachAddRowEvent($('.add-row'));

function attachAddBlockEvent(button) {
    button.click(function () {
        var column = $(this).parents('.column').first();
        var columnId = column.find('.id').first().val();

        var postData = {
            prefix : $(this).data('prefix')
        };

        $.post(appendUrl.block, postData, function (data) {
            var block = appendElement(column, $(data));
            attachRemoveBlockEvent(block.find('.btn-remove-block'));
        });
    });
}

function appendElement(parentElement, dataToAppend) {
    var list = parentElement.find('.children-list').first();
    list.append(dataToAppend);
    return dataToAppend;
}

attachAddBlockEvent($('.column-option'));

function attachRemoveBlockEvent(removeButton) {
    removeButton.click(function () {
        $(this).parents('.layout-block').first().remove();
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

$('.btn-block-modal').click(function() {
    var blockId = $(this).data('id');

    if ($('#modal-' + blockId).length > 0)
        $('#modal-' + blockId).modal('show');
    else {
        var postData = {
            id: blockId,
            prefix: $(this).data('prefix')
        };

        var self = this;

        $.get(
            appendUrl.blockModal + '?id=' + postData.id + '&prefix=' + postData.prefix, function (data)
            {
                var modalWindow = $(data);

                $(self).parent().find('.modal-container').first().append(modalWindow);

                $('#modal-' + blockId).modal();
                attachRemoveBlockEvent(modalWindow.find('.btn-remove-block'));
                attachHideModalEvent(modalWindow.find('.btn-modal-close'));
                attachSaveModalEvent(modalWindow.find('.btn-modal-save'));
            }
        );
    }
    
    return true;
});

function attachHideModalEvent(hideButton) {
    hideButton.click(function () {
        var modalWindow = $(this).parents('.modal').first();

        modalWindow.modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        modalWindow.parent().empty();
    });
}

function attachSaveModalEvent(saveButton) {
    saveButton.click(function () {
        var modalWindow = $(this).parents('.modal').first();

        modalWindow.modal('hide');
        //$('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });
}


