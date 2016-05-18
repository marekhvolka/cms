<?php
use yii\helpers\Url;

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

    output = output.replace(/ /g, delimiter, output); //nahradenie medzier

    output = output.toLowerCase(); //na male pismena

    output = output.replace('^[_\$a-zA-Z\xA0-\uFFFF][_\$a-zA-Z0-9\xA0-\uFFFF]*$', '')

    return output;
}
        
JS;
$this->registerJs($js);
?>