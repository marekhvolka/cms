<?php
/**
 * Created by PhpStorm.
 * User: Marek H
 * Date: 25. 8. 2016
 * Time: 9:01
 */

/* @var $name string */
/* @var $trueItem array */
/* @var $falseItem array */
/* @var $value string */

?>

<div class="toggle-switch-container" style="margin: 10px">
    <input type="text" class="hidden" name="<?= $name ?>" value="<?= $value ?>" class="input-value">

    <input type="text" class="hidden true-value" value="<?= $trueItem['value'] ?>">
    <input type="text" class="hidden false-value" value="<?= $falseItem['value'] ?>">

    <input type="checkbox" data-toggle="toggle" data-on="<?= $trueItem['label'] ?>"
           data-off="<?= $falseItem['label'] ?>" data-width="150">
</div>



