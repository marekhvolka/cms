<?php
/* @var $model \backend\models\Block */
use backend\components\AceEditor\AceEditorWidget;

/* @var $prefix string */

?>

<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Pridať text</h4>
</div>
<div class="modal-body">
    <textarea name="<?= $prefix . '[data]' ?>" class="form-control" rows="10"><?= $model->data ?></textarea>
</div>

