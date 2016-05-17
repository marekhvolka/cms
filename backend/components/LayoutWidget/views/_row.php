<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 15.05.16
 * Time: 0:30
 */

/* @var $row backend\models\Row */

?>

<!--ROW TO ADD-->
<div class="row layout-row<?=$row->id == null ? 'cloned-row' : ''; // Check for existing row. If new is created, is used for javascript cloning whole element and adding as new (dynamic adding).  ?>">
    <?php foreach ($row->columns as $column) : ?>
        <?= $this->render('_column', ['column' => $column]); ?>
    <?php endforeach;?>
</div>
