<?php
/* @var $block backend\models\Block */

?>

<div class="modal-dialog modal-xlg">
    <div class="modal-content">
        <div class="col-md-12" id="appendSmartSnippetInfo">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title snippet_edit_h4">
                    <span title="Rozbaliť / zbaliť všetko" style="margin-right: 5px; cursor: pointer;">
                        <i class="fa fa-sort"></i>
                    </span>
                    <span id="myModalLabelSmartSnippetAppend"><?= $block->snippetCode->snippet->name ?></span>

                    <div class="btn-group" data-toggle="buttons">
                        <?php foreach ($block->snippetCodes as $snippetCode) : ?>
                            <label class="btn btn-primary <?php ($block->snippetCode->id == $snippetCode->id) ? 'active' : ''; ?>">
                                <input type="radio" name="code_select" checked="checked" value="171">
                                <?= $snippetCode->name ?>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" class="btn btn-warning btn-xs btn-remove-var pull-right" 
                            style="right: 60px; top: 13px;" data-toggle="modal" 
                            data-target="#supportModal" title="Nápoveda">
                        <span class="fa fa-question"></span>
                    </button>
                </h4>
            </div>
            <div class="clearfix"></div>

            <div class="modal-body snippet-modal">
                <?php
                foreach ($block->snippetVarValues as $snippetVarValue) {
                    echo $this->render('_snippet-var-value', [
                        'model' => $snippetVarValue,
                        'productType' => $productType,
                    ]);
                }
                ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-modal-close" data-dismiss="modal">Zavrieť</button>
            <button type="button" class="btn btn-primary btn-modal-save">Uložiť</button>
            <button type="button" class="btn btn-info btn-modal-save-and-continue">Uložiť a pokračovať</button>
        </div>
    </div>
</div>

