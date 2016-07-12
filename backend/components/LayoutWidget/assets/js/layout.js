var appendUrl = {
        section: controllerUrl + '/' + 'append-section',
        row: controllerUrl + '/' + 'append-row',
        column: controllerUrl + '/' + 'append-columns',
        block: controllerUrl + '/' + 'append-block',
        blockModal: controllerUrl + '/' + 'append-block-modal',
        listItem: controllerUrl + '/' + 'append-list-item',
        blockModalContent: controllerUrl + '/' + 'append-block-modal-content'
    },
    body = $("body");

// Event for appending new section.
body.on(
    "click", '.btn-add-section', function () {
        var $this = $(this),
            layouts = $this.parents('.layouts'),
            postData = {
                prefix: $this.data('prefix'),
                productId: $this.data('product-id')
            };

        $.post(
            appendUrl.section, postData, function (data) {
                var section = appendElement(layouts, $(data));
                enableDragBy(section.find(".children-list.rows").toArray(), '.row-drag-by');
                enableDragBy(section.find(".children-list.blocks").toArray());
            }
        );
    }
);

body.on(
    "click", ".btn-remove-section", function () {
        $(this).parents('.section').remove();
    }
);

body.on(
    "click", ".btn-remove-row", function () {
        $(this).parents('.layout-row').first().remove();
    }
);

body.on(
    "click", ".add-row", function () {
        var $this = $(this),
            columnsByWidth = getColumnsWidths($this.data('row-type-width')),
            section = $this.parents('.section').first(),
            postData = {
                prefix: $this.parents('.dropdown-cols').find('.add-row-btn').first().data('prefix'),
                productId: $this.parents('.dropdown-cols').find('.add-row-btn').first().data('product-id')
            };

        $.post(
            appendUrl.row, postData, function (data) {
                var row = appendElement(section, $(data)),
                    postColumnData = {
                        width: columnsByWidth,
                        prefix: row.data('prefix'),
                        productId: row.data('product-id')
                    };

                $.post(
                    appendUrl.column, postColumnData, function (columnsData) {
                        var parsed = JSON.parse(columnsData);

                        for (var i = 0; i < parsed.length; i++) {
                            var column = appendElement(row, $(parsed[i]));
                            enableDragBy(column.find(".children-list.blocks").toArray());
                        }
                    }
                );
            }
        );
    }
);

body.on(
    "click", ".column-option", function () {
        var column = $(this).parents('.column').first();
        var mainButton = $(this).parents('.add-block').first().find('.add-block-btn').first();

        var postData = {
            prefix: mainButton.data('prefix'),
            productId: mainButton.data('product-id'),
            type: $(this).data('type')
        };

        $.post(
            appendUrl.block, postData, function (data) {
                appendElement(column, $(data));
            }
        );
    }
);

body.on(
    "click", ".btn-remove-block", function () {
        $(this).parents('.layout-block').first().remove();
    }
);

function appendElement(parentElement, dataToAppend) {
    parentElement.find('.children-list:first').append(dataToAppend);

    return $(dataToAppend);
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

function enableDragBy(items, dragBy) {
    dragula(items, {
        moves: function (el, container, handle) {
            return dragBy == null || $(handle).is(dragBy);
        },
        accepts: function (el, target, source, sibling) {
            return target == source;
        }
    });
}
enableDragBy($(".children-list.sections").toArray(), '.section-drag-by');
enableDragBy($(".children-list.rows").toArray(), '.row-drag-by');
enableDragBy($(".children-list.blocks").toArray());

// Handles elements (blocks, columns, rows) ordering.
/*
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

 */

//$('.dropdown-toggle').dropdown();


