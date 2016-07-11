<?php

/* @var $model \backend\models\Block */
use dosamigos\ckeditor\CKEditor;

/* @var $prefix string */

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span
            aria-hidden="true">×</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel">Pridať text</h4>
</div>
<div class="modal-body">
    <?= CKEditor::widget([
        'name' => $prefix . '[data]'
    ]) ?>
    <textarea class="form-control editor ckeditor" id="textModal" rows="3" name="<?= $prefix . '[data]' ?>"
    ><?= $model->data ?></textarea>
</div>
