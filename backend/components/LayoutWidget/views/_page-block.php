<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 15.05.16
 * Time: 0:31
 */

/* @var $pageBlock \backend\models\PageBlock */

?>

<div class="btn-group column-element column-text cloned-column-element" data-content="" role="group">
    <button type="button" class="btn btn-default btn-sm" title="Nastavenie publikovania">
        <span class="glyphicon glyphicon-globe"></span>
    </button>

    <button type="button" id="" class="btn btn-default btn-sm text-content-btn">
        <?php echo $pageBlock->name; ?>
    </button>

    <button type="button" class="btn btn-danger btn-sm" title="Zmazať element">
        <span class="glyphicon glyphicon-remove"></span>
    </button>
</div>
