var appendUrl = {
        section: controllerUrl + '/' + 'append-section',
        row: controllerUrl + '/' + 'append-row',
        column: controllerUrl + '/' + 'append-columns',
        block: controllerUrl + '/' + 'append-block',
        blockModal: controllerUrl + '/' + 'append-block-modal'
    },
    body = $("body");


// Event for appending new section.
$('.btn-add-section').click(function () {
    var $this = $(this),
        layouts = $this.parents('.layouts'),
        postData = {
            type: layoutType,
            prefix: $this.data('prefix')
        };

    $.post(appendUrl.section, postData, function (data) {
        appendElement(layouts, $(data));
    });
});

body.on("click", ".btn-remove-section", function () {
    $(this).parents('.section').remove();
});

body.on("click", ".btn-remove-row", function () {
    $(this).parents('.layout-row').first().remove();
});

body.on("click", ".add-row", function () {
    var $this = $(this),
        columnsByWidth = getColumnsWidths($this.data('row-type-width')),
        section = $this.parents('.section').first(),
        postData = {
            prefix: $this.data('prefix')
        };

    $.post(appendUrl.row, postData, function (data) {
        var row = appendElement(section, $(data)),
            postColumnData = {
                width: columnsByWidth,
                prefix: row.data('prefix')
            };

        $.post(appendUrl.column, postColumnData, function (columnsData) {
            $.each(JSON.parse(columnsData), function () {
                appendElement(row, this);
            });
        });
    });
});

body.on("click", ".column-option", function () {
    var column = $(this).parents('.column').first();

    var postData = {
        prefix: $(this).data('prefix')
    };

    $.post(appendUrl.block, postData, function (data) {
        appendElement(column, $(data));
    });
});

body.on("click", ".btn-remove-block", function () {
    $(this).parents('.layout-block').first().remove();
});


function appendElement(parentElement, dataToAppend) {
    parentElement
        .find('.children-list:first')
        .append(dataToAppend);

    return dataToAppend;
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

$('.btn-block-modal').click(function () {
    var blockId = $(this).data('id'),
        modal = $('#modal-' + blockId);

    // if it exists, it will get shown automatically... otherwise, load it
    if (modal.length == 0) {
        var postData = {
            id: blockId,
            prefix: $(this).data('prefix')
        },
            self = this;

        $.get(
            appendUrl.blockModal + '?id=' + postData.id + '&prefix=' + postData.prefix, function (data) {
                var modalWindow = $(data);

                $(self).parent().find('.modal-container').first().append(modalWindow);

                $('#modal-' + blockId).modal();
                attachHideModalEvent(modalWindow.find('.btn-modal-close'));
                attachSaveModalEvent(modalWindow.find('.btn-modal-save'));
            }
        );
    } else {
        modal.modal('show');
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


