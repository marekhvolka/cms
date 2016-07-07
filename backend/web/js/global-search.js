// GLOBAL SEARCH
// programmed by Juraj Mlich

$(
    function ()
    {
        var lastChanged = new Date(),
            timeout,
            input = $("#global-search-input");

        input.focus(
            function ()
            {
                if (input.val() != "")
                {
                    $(".global-search .data").stop().show();
                }
            }
        );

        input.blur(
            function ()
            {
                setTimeout(
                    function ()
                    {
                        $(".global-search .data").hide();
                    }, 100
                );
            }
        );

        input.on(
            'input', function ()
            {
                var now = new Date(),
                    value = $(this).val();

                if (timeout != null)
                {
                    clearTimeout(timeout);
                    timeout = null;
                }

                // so that we refresh after 300ms, not every user's stroke
                if (value != "")
                {
                    if (now.getTime() - lastChanged.getTime() < 300)
                    {
                        lastChanged = now;
                        refresh(value);
                    }
                    else
                    {
                        timeout = setTimeout(
                            function ()
                            {
                                refresh(value);
                            }, 500 - now.getTime() + lastChanged.getTime()
                        );
                    }
                }
                else
                {
                    $(".global-search .data").hide();
                }
            }
        );

        /**
         * Refresh the list of values.
         *
         * @param val
         */
        function refresh(val)
        {
            $.get(
                globalSearchUrl + "?q=" + encodeURI(val), function (data)
                {
                    $(".global-search .data li").remove();

                    var dataInDOM = $(".global-search .data"),
                        totalCount = data.snippet.length + data.snippet_code.length + data.page.length + data.product.length;

                    dataInDOM.show();

                    if (totalCount > 0)
                    {
                        function appendOneTypeOfData(items, type)
                        {
                            items.forEach(
                                function (i)
                                {
                                    var liItem = '<li class="' + i.class + '"><a href="' + i.link + '">' + i.name + ' (' + type + ')</a></li>';

                                    dataInDOM.append($(liItem));
                                }
                            );
                        }

                        appendOneTypeOfData(data.snippet, "snippet");
                        appendOneTypeOfData(data.snippet_code, "varianta snippetu");
                        appendOneTypeOfData(data.page, "stránka");
                        appendOneTypeOfData(data.product, "produkt");
                    }
                    else
                    {
                        dataInDOM.append($("<li>Žiadne výsledky</li>"));
                    }
                }
            );
        }
    }
);