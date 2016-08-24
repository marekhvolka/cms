<?php

/* @var $model \backend\models\Block */
/* @var $prefix string */

$id = rand(0, 100000000);
?>
<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Pridať text</h4>
</div>
<div class="modal-body">
    <textarea class="form-control editor" id="ckeditor<?= $id ?>" rows="3" name="<?= $prefix . '[data]' ?>"
    ><?= $model->data ?></textarea>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        CKEDITOR.replace("ckeditor<?= $id ?>", ckeditorConfig);
        CKEDITOR.dtd.$removeEmpty['i'] = false;
    });
</script>
