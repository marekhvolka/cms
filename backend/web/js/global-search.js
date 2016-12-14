// GLOBAL SEARCH
// programmed by Juraj Mlich

$(
    function () {
        var lastChanged = new Date(),
            timeout,
            input = $("#global-search-input"),
            selectedIndex = -1;

        input.focus(
            function () {
                if (input.val() != "") {
                    $(".global-search .data").stop().show();
                }
            }
        );

        input.blur(
            function () {
                setTimeout(
                    function () {
                        $(".global-search .data").hide();
                    }, 200
                );
            }
        );

        input.keydown(
            function (e) {
                var items = $(".global-search .data li");
                if (e.keyCode == 40) {
                    e.preventDefault();

                    if (items.length - 1 > selectedIndex) {
                        selectedIndex++;
                        items.filter('.active').removeClass('active');

                        $(items[selectedIndex]).addClass('active');
                    }
                }
                else if (e.keyCode == 38) {
                    e.preventDefault();

                    if (selectedIndex > -0) {
                        selectedIndex--;
                        items.filter('.active').removeClass('active');

                        $(items[selectedIndex]).addClass('active');
                    }
                }
                else if (e.keyCode == 13) {
                    e.preventDefault();
                    console.log("ok");
                    window.location.href = $(items[selectedIndex]).find('a').attr('href');
                }
            }
        );

        input.on(
            'input', function () {
                selectedIndex = -1;
                var now = new Date(),
                    value = $(this).val();

                if (timeout != null) {
                    clearTimeout(timeout);
                    timeout = null;
                }

                // so that we refresh after 300ms, not every user's stroke
                if (value != "") {
                    if (now.getTime() - lastChanged.getTime() < 300) {
                        lastChanged = now;
                        refresh(value);
                    }
                    else {
                        timeout = setTimeout(
                            function () {
                                refresh(value);
                            }, 500 - now.getTime() + lastChanged.getTime()
                        );
                    }
                }
                else {
                    $(".global-search .data").hide();
                }
            }
        );

        /**
         * Refresh the list of values.
         *
         * @param val
         */
        function refresh(val) {
            $.get(
                '/backend/web/page/global-search-results' + "?q=" + encodeURI(val), function (data) {
                    $(".global-search .data li").remove();

                    var dataInDOM = $(".global-search .data"),
                        totalCount = data.snippet.length + data.snippet_code.length + data.page.length +
                            data.product.length + data.word.length + data.actions.length;

                    dataInDOM.show();

                    if (totalCount > 0) {
                        function appendOneTypeOfData(items, type) {
                            items.forEach(
                                function (i) {
                                    var liItem = '<li class="' + i.class + '"><a tabindex="-1" href="' + i.link + '">' + i.name + ' (' + type + ')</a></li>';

                                    dataInDOM.append($(liItem));
                                }
                            );
                        }

                        appendOneTypeOfData(data.page, "stránka");
                        appendOneTypeOfData(data.post, "článok");
                        appendOneTypeOfData(data.product, "produkt");
                        appendOneTypeOfData(data.snippet, "snippet");
                        appendOneTypeOfData(data.snippet_code, "varianta snippetu");
                        appendOneTypeOfData(data.word, "slovník");
                        appendOneTypeOfData(data.actions, "akcie");
                    }
                    else {
                        dataInDOM.append($("<li>Žiadne výsledky</li>"));
                    }
                }
            );
        }
    }
);