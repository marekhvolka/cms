<?php
/* @var $model \backend\models\Block */
/* @var $prefix string */

$id = rand(0, 100000000);
?>

<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Pridať text</h4>
</div>
<div class="modal-body">
    <textarea class="form-control editor" id="editor<?= $id ?>" rows="3"
              name="<?= $prefix . '[data]' ?>"><?= $model->data ?></textarea>
</div>

<script>
    var editor = ace.edit("editor<?= $id ?>");
</script>

