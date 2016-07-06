<?php
use backend\assets\CKEditorAsset;
use backend\components\MultimediaModalWidget\MultimediaModalWidget;

/* @var $model \backend\models\Block */
/* @var $prefix string */
?>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel">Pridať text</h4>
</div>
<div class="modal-body">
<textarea class="form-control editor" id="textModal" rows="3" name="<?= $prefix . '[data]' ?>"
    ><?= $model->data ?></textarea>
</div>
