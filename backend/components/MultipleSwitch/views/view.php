<?php
/**
 * Created by PhpStorm.
 * User: Marek H
 * Date: 24. 8. 2016
 * Time: 18:30
 */
/* @var $value string */
/* @var $name string */
/* @var $items array */

?>
<div class="multiple-switch-container" style="margin:10px">
    <div class="btn-group">
        <input type="text" class="hidden input-value" value="<?= $value ?>" name="<?= $name ?>">
        <?php foreach ($items as $itemIndex => $item) : ?>
            <button type="button" class="btn btn-primary switch-button"
                    data-value="<?= $itemIndex ?>"><?= $item ?></button>
        <?php endforeach; ?>
    </div>
</div>
