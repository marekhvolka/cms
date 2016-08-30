var controllerUrl = '/backend/web/portal';
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

body.on('change', '.snippet-dropdown', function () {
    var postData = {
        prefix: $(this).data('prefix'),
        layoutOwnerId: $(this).data('layout-owner-id'),
        layoutOwnerType: $(this).data('layout-owner-type'),
        portalId: $(this).data('portal-id'),
        snippetId: $(this).val(),
        blockType: $(this).data('type')
    };

    var snippetName = $(this).find("option[value='" + $(this).val() + "']").text();

    var self = $(this);

    $.post(appendUrl.blockModalContent, postData, function (data) {
        self.parents('.btn-group').first().find('.btn-block-modal').first().html(snippetName);

        var modalContent = self.parents('.modal-main-content').first();
        modalContent.empty();
        modalContent.append($(data));

        rescanForms();
    });
});

body.on('change', '.parent-dropdown', function () {
    var postData = {
        prefix: $(this).data('prefix'),
        layoutOwnerId: $(this).data('layout-owner-id'),
        layoutOwnerType: $(this).data('layout-owner-type'),
        portalId: $(this).data('portal-id'),
        parentId: $(this).val(),
        blockType: $(this).data('type')
    };

    var snippetName = $(this).find("option[value='" + $(this).val() + "']").text();

    var self = $(this);

    $.post(appendUrl.blockModalContent, postData, function (data) {
        self.parents('.btn-group').first().find('.btn-block-modal').first().html(snippetName);

        var modalContent = self.parents('.modal-main-content').first();
        modalContent.empty();
        modalContent.append($(data));

        rescanForms();
    });
});

body.on('click', '.btn-block-modal', function () {
    var modalContainer = $(this).parents('.block').first().find('.modal-container');

    var blockId = $(this).data('id'),
        modal = $('#modal-' + blockId);

    // if it exists, it will get shown automatically... otherwise, load it
    if (modalContainer.children().length == 0) {
        var postData = {
                id: blockId,
                prefix: $(this).data('prefix'),
                blockType: $(this).data('block-type'),
                layoutOwnerId: $(this).data('layout-owner-id'),
                layoutOwnerType: $(this).data('layout-owner-type'),
                portalId: $(this).data('portal-id')
            },
            self = this;

        $.post(appendUrl.blockModal, postData, function (data) {
            var modalWindow = $(data);

            modalContainer.append(modalWindow);

            modalWindow.find('.children-list.list-items').each(function () {
                sortableListItem(this);
            });

            modalWindow.modal({
                backdrop: 'static',
                keyboard: false
            });

            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });

            rescanForms();
        });
    }
    else {
        modalContainer.children('.modal').first().modal('show');
    }

    return true;
});

body.on('click', '.btn-add-list-item', function () {
    var clickedBtn = $(this);
    var listPanel = clickedBtn.parents('.list-panel').first();

    var parentDropdownBtn = clickedBtn.parents('.add-list-item-dropdown');

    var postData = {
        prefix: parentDropdownBtn.data('prefix'),
        parentVarId: parentDropdownBtn.data('parent-var-id'),
        layoutOwnerId: parentDropdownBtn.data('layout-owner-id'),
        layoutOwnerType: parentDropdownBtn.data('layout-owner-type'),
        portalId: parentDropdownBtn.data('portal-id'),
        parentId: parentDropdownBtn.data('parent-id')
    };

    $.post(appendUrl.listItem, postData, function (data) {

        var listItem = $(data);
        
        if (clickedBtn.data('position') == 'begin') {
            listPanel.find('.children-list').first().prepend(listItem);
        } else if (clickedBtn.data('position') == 'end') {
            listPanel.find('.children-list').first().append(listItem);
        } else if (clickedBtn.data('position') == 'middle') {
            var directChildren = listPanel.find('.children-list').first().find('> *');
            $(directChildren[Math.floor(directChildren.length / 2)]).after(listItem);
        }

        listItem.addClass('added');
        listPanel.find('.list-items-count').first().text(listPanel.find('.children-list').first().children().length);

        listItem.find('.children-list.list-items').each(function () {
            sortableListItem(this);
        });

        listPanel.parents(".modal-main-content").first().find(".change-snippet-code").trigger('change'); // so that unneeded variables get removed
        setTimeout(function () {
            rescanForms();
        }, 0);

        $("input[data-check='switch']").bootstrapSwitch();
    });
});

body.on('click', '.btn-remove-list-item', function () {

    if (!confirm("Naozaj chceš zmazať túto položku?")) {
        return;
    }
    var listPanel = $(this).parents('.list-panel');

    var listItem = $(this).parents('.list-item').first();
    listItem.addClass('hidden');
    listItem.find('.removed').first().val(1);

    listPanel.first().find('.list-items-count').first().text(listPanel.find('.children-list').first().children().length);
});

body.on('click', '.btn-modal-save', function () {
    var modalWindow = $(this).parents('.modal').first();

    modalWindow.modal('hide');
    //$('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
});

body.on('click', '.btn-modal-close', function () {
    var modalWindow = $(this).parents('.modal').first();

    modalWindow.modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
});

function appendElement(parentElement, dataToAppend) {
    parentElement.find('.children-list:first').append(dataToAppend);

    return dataToAppend;
}

initializeMultimediaBtn();

$(document).ready(function () {
    $('.children-list.list-items').each(function () {
        sortableListItem(this);
    });
});

function sortableListItem(listItem) {
    Sortable.create(listItem, {
        handle: '.list-item-drag-by'
    });
}