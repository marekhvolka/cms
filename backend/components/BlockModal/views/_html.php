<?php
/* @var $model \backend\models\Block */
use backend\components\AceEditor\AceEditorWidget;

/* @var $prefix string */
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