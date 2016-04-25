<?php

/* @var $model backend\models\Snippet */
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
                                <input type="text" id="snippet-sekcia_id" value="<?= $model->sekcia_id ?>" class="form-control" name="Snippet[sekcia_id]" maxlength="30">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">class</span>
                                <input type="text" id="snippet-sekcia_class" value="<?= $model->sekcia_class ?>" class="form-control" name="Snippet[sekcia_class]" maxlength="30">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">style</span>
                                <input type="text" id="snippet-sekcia_style" value="<?= $model->sekcia_style ?>" class="form-control" name="Snippet[sekcia_style]" maxlength="30">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Nastavenia bloku</div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">id</span>
                                <input type="text" id="snippet-block_id" value="<?= $model->block_id ?>" class="form-control" name="Snippet[block_id]" maxlength="30">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">class</span>
                                <input type="text" id="snippet-block_class" value="<?= $model->block_class ?>" class="form-control" name="Snippet[block_class]" maxlength="30">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">style</span>
                                <input type="text" id="snippet-block_style" value="<?= $model->block_style ?>" class="form-control" name="Snippet[block_style]" maxlength="30">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>