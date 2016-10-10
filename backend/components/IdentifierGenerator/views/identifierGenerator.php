<?php

/* @var $this yii\web\View */
/* @var $idTextFrom string */
/* @var $idTextTo string */
/* @var $delimiter string */

?>

<?php

$js = <<<JS

$('#$idTextFrom').blur(function() {

    if ($('#$idTextTo').val().length == 0)
    {
        var input = $('#$idTextFrom').val();

        var output = generate(input, '$delimiter');

        $('#$idTextTo').val(output);
    }
});

function generate(input, delimiter)
{
    var output = input.trim(); //odstranenie medzier na zaciatku a konci
    output = output.replace(/\.$/, "");
    output = output.replace(/ - /g,"-");

    output = output.replace(/[ .]/g, delimiter, output); //nahradenie medzier

    output = output.toLowerCase(); //na male pismena

    output = cleanUpSpecialChars(output);

    output = output.replace('^[_\$a-zA-Z\xA0-\uFFFF][_\$a-zA-Z0-9\xA0-\uFFFF]*$', '')

    return output;
}

function cleanUpSpecialChars(str)
{
    str = str.replace(/[àáâãäå]/g,"a");
    str = str.replace(/[čçć]/g,"c");
    str = str.replace(/[ď]/g,"d");
    str = str.replace(/[éěèêëęėē]/g,"e");
    str = str.replace(/[íîïìįī]/g,"i");
    str = str.replace(/[ľĺł]/g,"l");
    str = str.replace(/[ňñń]/g,"n");
    str = str.replace(/[ôóöòõœøō]/g,"o");
    str = str.replace(/[ŕř]/g,"r");
    str = str.replace(/[šßś]/g,"s");
    str = str.replace(/[ť]/g,"t");
    str = str.replace(/[úůûüùū]/g,"u");
    str = str.replace(/[ýÿ]/g,"y");
    str = str.replace(/[žźż]/g,"z");

    str = str.replace(/,/g, '');
    str = str.replace(/\?/g, '');
    str = str.replace(/\!/g, '');
    str = str.replace(/:/g, '');
    str = str.replace(/\./g, '');
    //str = str.replace(/\\/g, '');
    str = str.replace(/\//g, '');
    str = str.replace(/\(/g, '');
    str = str.replace(/\)/g, '');
    str = str.replace(/\[/g, '');
    str = str.replace(/\]/g, '');

    return str;
}
        
JS;
$this->registerJs($js);
?>