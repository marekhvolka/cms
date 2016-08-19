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
    "click", '.btn-add-section', function ()
    {
        var $this = $(this),
            layouts = $this.parents('.layouts'),
            postData = {
                prefix: $this.data('prefix'),
                pageId: $this.data('page-id'),
                portalId: $this.data('portal-id')
            };

        $.post(
            appendUrl.section, postData, function (data)
            {
                var section = appendElement(layouts, $(data));
                enableDragBy(section.find(".children-list.rows").toArray(), '.row-drag-by');
                enableDragBy(section.find(".children-list.blocks").toArray());

                //enableDropSection(section);

                rescanForms();
            }
        );
    }
);

body.on(
    "click", ".btn-remove-section", function ()
    {
        $(this).parents('.section').remove();
    }
);

body.on(
    "click", ".btn-remove-row", function ()
    {
        $(this).parents('.layout-row').first().remove();
    }
);

body.on(
    'click', '.open-section-options', function (e)
    {
        $(this).parents('.panel-title').find('.modal').modal('show');
        e.preventDefault();
    }
);

body.on(
    'click', '.open-column-options', function (e)
    {
        $(this).parents('.panel-heading').find('.modal').modal('show');
        e.preventDefault();
    }
);

body.on(
    "click", ".add-row", function ()
    {
        var $this = $(this),
            columnsByWidth = getColumnsWidths($this.data('row-type-width')),
            section = $this.parents('.section').first(),
            postData = {
                prefix: $this.parents('.dropdown-cols').find('.add-row-btn').first().data('prefix'),
                pageId: $this.parents('.dropdown-cols').find('.add-row-btn').first().data('page-id'),
                portalId: $this.parents('.dropdown-cols').find('.add-row-btn').first().data('portal-id')
            };

        $.post(
            appendUrl.row, postData, function (data)
            {
                var row = appendElement(section, $(data)),
                    postColumnData = {
                        width: columnsByWidth,
                        prefix: row.data('prefix'),
                        pageId: row.data('page-id'),
                        portalId: row.data('portal-id')
                    };

                $.post(
                    appendUrl.column, postColumnData, function (columnsData)
                    {
                        var parsed = JSON.parse(columnsData);

                        for (var i = 0; i < parsed.length; i++)
                        {
                            var column = appendElement(row, $(parsed[i]));
                            //enableDragBy(column.find(".children-list.blocks").toArray());
                        }

                        rescanForms();
                    }
                );
            }
        );
    }
);

body.on(
    "click", ".add-block", function ()
    {
        var column = $(this).parents('.column').first();
        var mainButton = $(this).parents('.add-block-dropdown').first().find('.add-block-btn').first();

        var postData = {
            prefix: mainButton.data('prefix'),
            pageId: mainButton.data('page-id'),
            portalId: mainButton.data('portal-id'),
            type: $(this).data('type')
        };

        $.post(
            appendUrl.block, postData, function (data)
            {
                var block = appendElement(column, $(data));

                //block.draggable({revert: 'invalid'});

                rescanForms();
            }
        );
    }
);

body.on(
    "click", ".btn-remove-block", function ()
    {
        $(this).parents('.layout-block').first().remove();
    }
);

function appendElement(parentElement, dataToAppend)
{
    parentElement.find('.children-list:first').append(dataToAppend);

    return $(dataToAppend);
}

function getColumnsWidths(rowType)
{
    switch (rowType)
    {
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

body.on(
    'shown.bs.modal', function (e)
    {
        disableDragAndDrop = true;
    }
);

body.on(
    'hidden.bs.modal', function (e)
    {
        disableDragAndDrop = false;
    }
);

$('.children-list.sections').each(function() {
    Sortable.create(this, {
        group: '.children-list.sections',

        onAdd: function (/**Event*/evt) {
            evt.item.getElementsByClassName('area_id')[0].value = evt.to.parentElement.parentElement.getElementsByClassName('model_id')[0].value;
        }
    });
});

$('.children-list.rows').each(function() {
    Sortable.create(this, {
        group: '.children-list.rows',

        onAdd: function (/**Event*/evt) {
            evt.item.getElementsByClassName('section_id')[0].value = evt.to.parentElement.parentElement.getElementsByClassName('model_id')[0].value;
        }
    });
});

$('.children-list.blocks').each(function() {
    Sortable.create(this, {
        group: '.children-list.blocks',

        onAdd: function (/**Event*/evt) {
            evt.item.getElementsByClassName('column_id')[0].value = evt.to.parentElement.parentElement.getElementsByClassName('model_id')[0].value;
        }
    });
});