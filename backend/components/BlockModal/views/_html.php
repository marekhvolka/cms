<?php
/* @var $model \backend\models\Block */
use backend\components\AceEditor\AceEditorWidget;

/* @var $prefix string */

$id = rand(0, 100000000);
?>

<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Pridať text</h4>
</div>
<div class="modal-body">

    <?= AceEditorWidget::widget([
        'name' => $prefix . '[data]',
        'value' => $model->data,
        'theme' => 'chrome',
        'aceOptions' => [
            'showPrintMargin' => false,
            "maxLines" => 29,
            "minLines" => 5
        ]
    ]); ?>
</div>

<script>
    var editor = ace.edit("editor<?= $id ?>");
</script>

