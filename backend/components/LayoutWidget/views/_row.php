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
<div class="row cloned-row">
    <?php foreach ($row->columns as $column) : ?>
        <?= $this->render('_column', ['column' => $column]); ?>
    <?php endforeach;?>
</div>
