<?php
use backend\assets\CKEditorAsset;
use backend\components\MultimediaModalWidget\MultimediaModalWidget;

CKEditorAsset::register($this);
?>

<div class="modal fade in" id="textModalAdd" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: block;"><div class="modal-backdrop fade in"></div>
    <div class="modal-dialog modal-xlg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="cancelSaveNotif()" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Pridať text</h4>
            </div>
            <div class="modal-body">
                <textarea class="form-control editor ckeditor" id="textModal" rows="3">
                    <?= $model->data ?>
                </textarea>
            </div>
            <input type="hidden" id="idBlockLayoutText">
            <input type="hidden" id="idSekciaText">
            <input type="hidden" id="idLocationText">
            <input type="hidden" id="idHiddenText" value="snippet_12028401_h_3725790">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
                <button type="button" class="btn btn-primary" id="textAdd" onclick="addTextToBlockLayout()" style="display: none;">Pridať</button>
                <button type="button" class="btn btn-primary" id="textEdit" style="" onclick="editTextToBlockLayout()">Uložiť</button>
            </div>
        </div>
    </div>
</div>
<?= MultimediaModalWidget::widget(['successCallJSFunction' => "window.multimediaFileSelected", "onlyImages" => true]) ?>