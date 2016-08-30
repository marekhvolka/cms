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

/* ==========================================================================
 Section
 ========================================================================== */

// Event for appending new section.
body.on("click", '.add-section-btn', function () {
    var $this = $(this),
        layouts = $this.parents('.layouts'),
        postData = {
            prefix: $this.data('prefix'),
            layoutOwnerId: $(this).data('layout-owner-id'),
            layoutOwnerType: $(this).data('layout-owner-type'),
            portalId: $this.data('portal-id')
        };

    $.post(appendUrl.section, postData, function (data) {
        var section = appendElement(layouts, $(data));

        sortableRow(section.find('.children-list.rows').first()[0]);

        rescanForms();
    });
});

body.on("click", ".btn-remove-section", function () {
    if (!confirm("Naozaj chceš zmazať túto sekciu?")) {
        return;
    }
    removeItem($(this).parents('.section'));
});

body.on('click', '.open-section-options', function (e) {
    $(this).parents('.panel-title').find('.modal').modal('show');
    e.preventDefault();
});

/* ==========================================================================
 Row
 ========================================================================== */

body.on("click", ".add-row", function () {
    var $this = $(this),
        columnsByWidth = getColumnsWidths($this.data('row-type-width')),
        section = $this.parents('.section').first(),
        postData = {
            prefix: $this.parents('.dropdown-cols').find('.add-row-btn').first().data('prefix'),
            layoutOwnerId: $this.parents('.dropdown-cols').find('.add-row-btn').first().data('layout-owner-id'),
            layoutOwnerType: $this.parents('.dropdown-cols').find('.add-row-btn').first().data('layout-owner-type'),
            portalId: $this.parents('.dropdown-cols').find('.add-row-btn').first().data('portal-id')
        };

    $.post(appendUrl.row, postData, function (data) {
        var row = appendElement(section, $(data)),
            postColumnData = {
                width: columnsByWidth,
                prefix: row.data('prefix'),
                layoutOwnerId: row.data('layout-owner-id'),
                layoutOwnerType: row.data('layout-owner-type'),
                portalId: row.data('portal-id')
            };

        $.post(appendUrl.column, postColumnData, function (columnsData) {
            var parsed = JSON.parse(columnsData);

            for (var i = 0; i < parsed.length; i++) {
                var column = appendElement(row, $(parsed[i]));
                sortableBlock(column.find('.children-list.blocks').first()[0]);
            }

            rescanForms();
        });
    });
});

body.on("click", ".btn-remove-row", function () {
    if (!confirm("Naozaj chceš zmazať tento riadok?")) {
        return;
    }
    removeItem($(this).parents('.layout-row').first());
});

/* ==========================================================================
 Column
 ========================================================================== */

body.on('click', '.open-column-options', function (e) {
    $(this).parents('.panel-heading').find('.modal').modal('show');
    e.preventDefault();
});

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

/* ==========================================================================
 Block
 ========================================================================== */

body.on("click", ".add-block", function () {
    var column = $(this).parents('.column').first();
    var mainButton = $(this).parents('.add-block-dropdown').first().find('.add-block-btn').first();

    var postData = {
        prefix: mainButton.data('prefix'),
        layoutOwnerId: mainButton.data('layout-owner-id'),
        layoutOwnerType: mainButton.data('layout-owner-type'),
        portalId: mainButton.data('portal-id'),
        type: $(this).data('type')
    };

    $.post(appendUrl.block, postData, function (data) {
        var block = appendElement(column, $(data));
        rescanForms();
    });
});

body.on("click", ".btn-remove-block", function () {
    if (!confirm("Naozaj chceš zmazať tento blok?")) {
        return;
    }
    removeItem($(this).parents('.layout-block').first());
});

function appendElement(parentElement, dataToAppend) {
    parentElement.find('.children-list:first').append(dataToAppend);
    return $(dataToAppend);
}

body.on('shown.bs.modal', function (e) {
    disableDragAndDrop = true;
});

body.on('hidden.bs.modal', function (e) {
    disableDragAndDrop = false;
});

function sortableSection(section) {
    Sortable.create(section, {
        group: '.children-list.sections',

        onAdd: function (/**Event*/evt) {
            var oldItem = $(evt.item).clone();
            oldItem.addClass('hidden');
            oldItem.find('.removed').first().val(1);
            $(evt.from).append(oldItem);

            var newId = Math.floor((Math.random() * 1000) + 20);

            var oldPrefix = evt.item.getAttribute('data-prefix');
            var newPrefix = evt.to.parentElement.parentElement.getAttribute('data-prefix') + '[Section][' + newId + ']';

            while(evt.item.innerHTML.indexOf(oldPrefix) > -1) {
                evt.item.innerHTML = evt.item.innerHTML.replace(oldPrefix, newPrefix);
            }
        }
    });
}

function sortableRow(row) {
    Sortable.create(row, {
        group: '.children-list.rows',

        onAdd: function (/**Event*/evt) {
            var oldItem = $(evt.item).clone();
            oldItem.addClass('hidden');
            oldItem.find('.removed').first().val(1);
            $(evt.from).append(oldItem);

            var newId = Math.floor((Math.random() * 1000) + 20);

            var oldPrefix = evt.item.getAttribute('data-prefix');
            var newPrefix = evt.to.parentElement.parentElement.getAttribute('data-prefix') + '[Row][' + newId + ']';

            while(evt.item.innerHTML.indexOf(oldPrefix) > -1) {
                evt.item.innerHTML = evt.item.innerHTML.replace(oldPrefix, newPrefix);
            }
        }
    });
}

function sortableBlock(block) {
    Sortable.create(block, {
        group: '.children-list.blocks',

        onAdd: function (/**Event*/evt) {

            var oldItem = $(evt.item).clone();
            oldItem.addClass('hidden');
            oldItem.find('.removed').first().val(1);
            $(evt.from).append(oldItem);

            var newId = Math.floor((Math.random() * 1000) + 20);

            var oldPrefix = evt.item.getAttribute('data-prefix');
            var newPrefix = evt.to.parentElement.getAttribute('data-prefix') + '[Block][' + newId + ']';

            while(evt.item.innerHTML.indexOf(oldPrefix) > -1) {
                evt.item.innerHTML = evt.item.innerHTML.replace(oldPrefix, newPrefix);
            }
        }
    });
}

$('.children-list.sections').each(function () {
    sortableSection(this);
});

$('.children-list.rows').each(function () {
    sortableRow(this);
});

$('.children-list.blocks').each(function () {
    sortableBlock(this);
});