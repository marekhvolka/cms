<?php
/* @var $model backend\models\SnippetCode */
/* @var $prefix string */
?>

<div class="form-group">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Nastavenia sekcie</div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">id</span>
                                <input type="text" id="snippet-section_id" value="<?= $model->section_id ?>"
                                       class="form-control" name="<?= $prefix ?>[section_id]" maxlength="30">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">class</span>
                                <input type="text" id="snippet-section_class" value="<?= $model->section_class ?>"
                                       class="form-control" name="<?= $prefix ?>[section_class]" maxlength="30">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">style</span>
                                <input type="text" id="snippet-section_style" value="<?= $model->section_style ?>"
                                       class="form-control" name="<?= $prefix ?>[section_style]">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Nastavenia stĺpca</div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">id</span>
                                <input type="text" id="snippet-column_id" value="<?= $model->column_id ?>"
                                       class="form-control" name="<?= $prefix ?>[column_id]" maxlength="30">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">class</span>
                                <input type="text" id="snippet-column_class" value="<?= $model->column_class ?>"
                                       class="form-control" name="<?= $prefix ?>[column_class]" maxlength="30">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">style</span>
                                <input type="text" id="snippet-column_style" value="<?= $model->column_style ?>"
                                       class="form-control" name="<?= $prefix ?>[column_style]" maxlength="30">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>