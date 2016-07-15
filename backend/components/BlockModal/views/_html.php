<?php
/* @var $model \backend\models\Block */
/* @var $prefix string */

$id = rand(0, 100000000);
?>

<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Pridať text</h4>
</div>

<?= trntv\aceeditor\AceEditor::widget([
    // You can either use it for model attribute
    'model' => $model,
    'attribute' => 'data',

    'mode' => 'php', // programing language mode. Default "html"
    'theme' => 'chrome', // editor theme. Default "github"
    'options' => [
        'name' => $prefix . "[data]",
        'value' => $model->data,
        'id' => 'html' . hash('md5', $prefix)
    ]
])
?>



