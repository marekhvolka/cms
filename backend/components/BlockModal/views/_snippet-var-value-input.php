<?php 
/* @var $model backend\models\SnippetVarValue */
/* @var $defaultValue string */
/* @var $input string */

?>
<div class="form-group code" style="position: relative;">
    <label class="col-sm-2 control-label" for="<?= $model->id ?>"><?= $model->var->identifier ?></label>
    <div class="col-sm-10">
        <div class="input-group">
            <?=$input?>
            <span class="input-group-addon"><i></i></span>
        </div>

        <?php if (!empty($defaultValue)) : ?>
            <p class="text-muted doplnInfo">Prednastavená hodnota pre toto pole je <strong><?= htmlentities($defaultValue) ?></strong></p>
        <?php endif; ?>
    </div>
</div>