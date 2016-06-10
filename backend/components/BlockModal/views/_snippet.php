
    <form id="SmartSnippetFormModal" action="#" class="form-horizontal" method="POST">
        <div class="modal-dialog modal-xlg">
            <div class="modal-content">
                <div class="col-md-12" id="appendSmartSnippetInfo">
                    <div class="modal-header">
                        <button type="button" onclick="cancelSaveNotif()" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title snippet_edit_h4">
                            <span title="Rozbaliť / zbaliť všetko" onclick="toggleSmartSnippetListAll()" style="margin-right: 5px; cursor: pointer;">
                                <i class="fa fa-sort"></i>
                            </span>
                            <span id="myModalLabelSmartSnippetAppend"><?= $model->snippetCode->snippet->name ?></span>

                            <div class="btn-group" data-toggle="buttons">
                                <?php foreach ($model->snippetCode->snippet->snippetCodes as $snippetCode) : ?>
                                    <label class="btn btn-primary <?php ($model->snippetCode->id == $snippetCode->id) ? 'active': '';?>">
                                        <input type="radio" name="code_select" onchange="changeSmartSnippetCode($(this).val())" checked="checked" value="171">
                                        <?= $snippetCode->name ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <button type="button" class="btn btn-warning btn-xs btn-remove-var pull-right" style="right: 60px; top: 13px;" data-toggle="modal" data-target="#supportModal" title="Nápoveda"><span class="fa fa-question"></span></button>
                        </h4>
                    </div>
                    <div class="clearfix"></div>
                    <script>$(".alternative_hidden").css('width', $(document).width()*0.5)</script>
                    <div class="modal-body snippet-modal">
                        <?php
                            foreach ($model->snippetVarValues as $variable)
                            {
                                echo $this->render('_snippet_var', [
                                    'model' => $variable,
                                    'productType' => $productType,
                                ]);
                            }
                        ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
                    <button type="button" class="btn btn-primary" onclick="editSmartSnippetToBlockLayout()">Uložiť</button>
                    <button type="button" class="btn btn-info" onclick="editSmartSnippetToBlockLayout('pokracuj')">Uložiť a pokračovať</button>
                </div>
            </div>
        </div>
    </form>
