<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $idTextFrom string */
/* @var $idTextTo string */

?>

<?php
$url = Url::to(['site/generate-identifier']);

$js = <<<JS

$('#$idTextFrom').blur(function() {
    var identifierData = {
        name: $('#$idTextFrom').val(),
        delimiter: '$delimiter',
    }
    $.post('$url', identifierData, function(data, status){
        if ($('#$idTextTo').val().length == 0){
            $('#$idTextTo').val(data);
        }
    });
});
        
JS;
$this->registerJs($js);
?>