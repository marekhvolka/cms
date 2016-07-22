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

body.on(
    'change', '.snippet-dropdown', function () {
        var postData = {
            prefix: $(this).data('prefix'),
            pageId: $(this).data('page-id'),
            portalId: $(this).data('portal-id'),
            snippetId: $(this).val(),
            blockType: $(this).data('type')
        };

        var snippetName = $(this).find("option[value='" + $(this).val() + "']").text();

        var self = $(this);

        $.post(
            appendUrl.blockModalContent, postData, function (data) {
                self.parents('.btn-group').first().find('.btn-block-modal').first().html(snippetName);

                var modalContent = self.parents('.modal-main-content').first();
                modalContent.empty();
                modalContent.append($(data));

                setTimeout(function () {
                    rescanForms();
                }, 0);
            }
        );
    }
);

body.on(
    'change', '.parent-dropdown', function () {
        var postData = {
            prefix: $(this).data('prefix'),
            pageId: $(this).data('page-id'),
            portalId: $(this).data('portal-id'),
            parentId: $(this).val(),
            blockType: $(this).data('type')
        };

        var snippetName = $(this).find("option[value='" + $(this).val() + "']").text();

        var self = $(this);

        $.post(
            appendUrl.blockModalContent, postData, function (data) {
                self.parents('.btn-group').first().find('.btn-block-modal').first().html(snippetName);

                var modalContent = self.parents('.modal-main-content').first();
                modalContent.empty();
                modalContent.append($(data));

                setTimeout(function () {
                    rescanForms();
                }, 0);
            }
        );
    }
);

body.on(
    'click', '.btn-block-modal', function () {
        var modalContainer = $(this).parents('.block').first().find('.modal-container');

        var blockId = $(this).data('id'),
            modal = $('#modal-' + blockId);

        // if it exists, it will get shown automatically... otherwise, load it
        if (modalContainer.children().length == 0) {
            var postData = {
                    id: blockId,
                    prefix: $(this).data('prefix'),
                    blockType: $(this).data('block-type'),
                    pageId: $(this).data('page-id'),
                    portalId: $(this).data('portal-id')
                },
                self = this;

            $.post(
                appendUrl.blockModal, postData, function (data) {
                    var modalWindow = $(data);

                    modalContainer.append(modalWindow);

                    enableDragBy(modalContainer.find(".children-list.list-items").toArray(), '.list-item-drag-by');

                    modalWindow.modal({
                        backdrop: 'static',
                        keyboard: false
                    });

                    $(function () {
                        $('[data-toggle="tooltip"]').tooltip()
                    });

                    setTimeout(function () {
                        rescanForms();
                    }, 0);
                }
            );
        }
        else {
            modalContainer.children('.modal').first().modal('show');
        }

        return true;
    }
);

body.on(
    'click', '.btn-add-list-item', function () {
        var listPanel = $(this).parents('.list-panel').first();

        var postData = {
            prefix: $(this).data('prefix'),
            parentVarId: $(this).data('parent-var-id'),
            pageId: $(this).data('page-id'),
            portalId: $(this).data('portal-id'),
            parentId: $(this).data('parent-id')
        };

        $.post(
            appendUrl.listItem, postData, function (data) {
                appendElement(listPanel, $(data));
                listPanel.find('.list-items-count').first().text(listPanel.find('.children-list').first().children().length);
                enableDragBy(listPanel.find(".children-list.list-items").toArray(), '.list-item-drag-by');
                listPanel.parents(".modal-main-content").first().find(".change-snippet-code").trigger('change'); // so that unneeded variables get removed
                setTimeout(function () {
                    rescanForms();
                }, 0);
            }
        );
    }
);

body.on(
    'click', '.btn-remove-list-item', function () {
        var listPanel = $(this).parents('.list-panel');

        $(this).parents('.list-item').first().remove();
        listPanel.first().find('.list-items-count').first().text(listPanel.find('.children-list').first().children().length);
    }
);

body.on(
    'click', '.btn-modal-save', function () {
        var modalWindow = $(this).parents('.modal').first();

        modalWindow.modal('hide');
        //$('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }
);

body.on(
    'click', '.btn-modal-close', function () {
        var modalWindow = $(this).parents('.modal').first();

        modalWindow.modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }
);

function appendElement(parentElement, dataToAppend) {
    parentElement.find('.children-list:first').append(dataToAppend);

    return dataToAppend;
}

body.on('click', ".var-value a.open-multimedia", function (e) {
    e.preventDefault();
    var assigningTo = $(this).parents('.var-value').first().find('.value');

    Multimedia.get().show(function (path) {
        assigningTo.val(path);
    });
});