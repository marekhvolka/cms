<?php
use backend\assets\CKEditorAsset;
use backend\components\MultimediaModalWidget\MultimediaModalWidget;

/* @var $model \backend\models\Block */
/* @var $prefix string */

CKEditorAsset::register($this);
?>


<div class="modal-header">
    <button type="button" onclick="cancelSaveNotif()" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel">Pridať text</h4>
</div>
<div class="modal-body">
    <textarea class="form-control editor ckeditor" id="textModal" rows="3" name="<?= $prefix . '[data]' ?>">
        <?= $model->data ?>
    </textarea>
</div>


<?= MultimediaModalWidget::widget(['successCallJSFunction' => "window.multimediaFileSelected", "onlyImages" => true]) ?>