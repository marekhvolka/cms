<?php

/* @var $model \backend\models\Block */
/* @var $prefix string */

?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span
                aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Pridať text</h4>
    </div>
    <div class="modal-body">
    <textarea class="form-control editor ckeditor" id="textModal" rows="3" name="<?= $prefix . '[data]' ?>"
        ><?= $model->data ?></textarea>
    </div>


<?php /* MultimediaModalWidget::widget(['successCallJSFunction' => "window.multimediaFileSelected", "onlyImages" => true]) ?>

<script type="text/javascript">
    CKEDITOR.replace('textModal');
</script>

 */ ?>