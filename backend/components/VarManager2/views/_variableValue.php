<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 18.05.16
 * Time: 23:24
 */
/* @var $varValue */

?>

<div class="form-group field-<?=$varValue->var_id?> active-field">
    <label class="col-sm-2 control-label label-var"><?=$varValue->var->name?></label>
    <div class="col-sm-10 var-value">
        <div class="input-group">
            <?php if($varValue->var->description): ?>
                <span class="input-group-addon">
                    <a class='my-tool-tip' data-toggle="tooltip" data-placement="left" title="<?=$varValue->var->description?>">
                        <!-- The class CANNOT be tooltip... -->
                        <i class='glyphicon glyphicon-question-sign'></i>
                    </a>
                </span>
            <?php endif;?>
            <?php switch($varValue->var->type->identifier):
                case 'textarea': ?>
                    <textarea id="field-<?=$varValue->var_id?>" class="form-control" rows="5"
                              placeholder="<?=$varValue->var->name?>"
                              data-type="<?=$varValue->var->type->identifier?>" data-name="<?=$varValue->var->name?>"
                              name="var[<?=$varValue->var_id?>][]">
                                      <?=$varValue->value?>
                    </textarea>
                    <?php break; ?>
                <?php default: ?>
                    <input type="text" class="form-control"
                           value="<?=$varValue->value?>" placeholder="<?=$varValue->var->name?>"
                           data-type="<?=$varValue->var->type->identifier?>" data-name="<?=$varValue->var->name?>"
                           name="var[<?=$varValue->var_id?>][]">
                    <?php break; ?>
                <?php endswitch; ?>
            <span class="input-group-btn rmv-btn" data-field-id="<?=$varValue->var_id?>">
                <button class="btn btn-danger remove-field" type="button" >
                    <span class="glyphicon glyphicon-remove"></span>
                </button>
            </span>
        </div>
    </div>
</div>

<?php

$js = <<<JS

$('.rmv-btn').click(function() {
    var id = $(this).attr('data-field-id');
    var elementClass = '.field-' + id + '.active-field';
    $(elementClass).remove();

    $('#types-dropdown').find('option').prop('disabled', false);
    $('#types-dropdown').select2();
});

JS;

$this->registerJs($js);
?>
