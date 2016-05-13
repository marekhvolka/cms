$('#save-btn').click(function () {
    var data = prepareData();
    $.post(pageParams.url, {data: data}, function (result) {
        console.log(result);
    });
});

function prepareData() {
    // Loop trhough Sections.
    var sections = $('.section');
    sections.each(function() {
        
        //$(this)
    });
}


