var appendUrl = {
    code: controllerUrl + '/' + 'append-code',
    snippetVar: controllerUrl + '/' + 'append-var',
    listBox: controllerUrl + '/' + 'append-list-box',
    defaultValue: controllerUrl + '/' + 'append-default-value'
};

var listTypeId = 5;

var body = $("body");

body.on(
    'click', '.btn-add-snippet-code', function ()
    {
        var postData = {
            prefix: $(this).data('prefix')
        };

        $.post(
            appendUrl.code, postData, function (data)
            {
                $('.snippet-codes').append($(data));
            }
        );
    }
);

body.on(
    'click', '.btn-remove-snippet-code', function ()
    {
        $(this).parents('.snippet-code').remove();
    }
);

body.on(
    'click', '.btn-add-snippet-var', function ()
    {
        var url = appendUrl.snippetVar;

        var postData = {
            prefix: $(this).data('prefix')
        };

        var self = this;

        $.post(
            url, postData, function (data)
            {
                $(self).parents('.snippet-vars').first().find('.snippet-vars-container').first().append($(data));
            }
        );
    }
);

body.on(
    'click', '.btn-remove-snippet-var', function ()
    {
        $(this).parents('.snippet-var').first().remove();
    }
);

body.on(
    'change', '.select-var-type', function ()
    {
        if ($(this).val() == listTypeId)
        {        // If selected type is List.

            var postData = {
                prefix: $(this).data('prefix')
            };

            var self = this;

            $.post(
                appendUrl.listBox, postData, function (data)
                {
                    var listBoxContainer = $(self).parents('.var-body').first().find('.list-box-container');
                    listBoxContainer.append($(data));
                }
            );
        }
        else
        {
            $(this).parents('.var-body').first().find('.list-box-container').empty();
        }
    }
);

body.on(
    'click', '.btn-remove-snippet-default-value', function ()
    {
        $(this).parents('li').first().remove();
    }
);

body.on(
    'click', '.btn-add-snippet-default-value', function ()
    {
        var _this = $(this);

        var postData = {};

        if (parent)
        {
            postData.id = parent.find('.variable-id').val();
            ;
        }

        $.post(
            appendUrl.defaultValue, function (data)
            {
                var row = $('<li></li>');
                var row = row.appendTo(_this.parents(varWrapper).first());
                var appendedDiv = $(data);
                $(row).append(appendedDiv);
            }
        );
    }
);
