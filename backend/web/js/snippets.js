var appendUrl = {
    code: controllerUrl + '/' + 'append-code',
    snippetVar: controllerUrl + '/' + 'append-var',
    listBox: controllerUrl + '/' + 'append-list-box',
    defaultValue: controllerUrl + '/' + 'append-default-value'
};

var listTypeId = 5;

var body = $("body");

body.on('click', '.btn-add-snippet-code', function () {
    var postData = {
        prefix: $(this).data('prefix')
    };

    $.post(appendUrl.code, postData, function (data) {
        $('.snippet-codes').append($(data));
        rescanForms();
    });
});

body.on('click', '.btn-remove-snippet-code', function () {
    removeItem($(this).parents('.snippet-code'));
});

body.on('click', '.btn-add-snippet-var', function () {
    var url = appendUrl.snippetVar;

    var postData = {
        prefix: $(this).data('prefix')
    };

    var self = this;

    $.post(url, postData, function (data) {
        $(self).parents('.snippet-vars').first().find('.snippet-vars-container').first().append($(data));
        rescanForms();
    });
});

body.on('click', '.btn-remove-snippet-var', function () {
    removeItem($(this).parents('.snippet-var').first());
});

body.on('change', '.select-var-type', function () {
    if ($(this).val() == listTypeId) {        // If selected type is List.

        var postData = {
            prefix: $(this).data('prefix')
        };

        var self = this;

        $.post(appendUrl.listBox, postData, function (data) {
            var listBoxContainer = $(self).parents('.var-body').first().find('.list-box-container');
            listBoxContainer.append($(data));

            rescanForms();
        });
    }
    else {
        $(this).parents('.var-body').first().find('.list-box-container').empty();
    }
});

body.on('click', '.btn-remove-snippet-default-value', function () {
    removeItem($(this).parents('.row').first());
});

body.on('click', '.btn-add-snippet-default-value', function () {
    var postData = {
        parentPrefix: $(this).data('parent-prefix')
    };

    var self = $(this);

    $.post(appendUrl.defaultValue, postData, function (data) {
        self.parents('.snippet-var-default-values').first().append($(data));

        rescanForms();
    });
});

body.on('click', '.btn-alternative-usage', function (e) {
    e.preventDefault();

    var id = $(this).parents(".panel-heading").first().next(".panel-body").find(".snippet-code-id").val();

    $.get(snippetCodeUsageUrl.replace("code-id", id), function (data) {
        var modal = $("#alternativeUsedIn");
        modal.find(".modal-body").empty().append($(data));
        modal.modal("show");

        rescanForms();
    });
});