<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 15.05.16
 * Time: 0:30
 */

/* @var $row backend\models\Row */

?>

<?php 
// Check for row existence. 
// If new created, is used for javascript cloning whole element and adding as new (dynamic adding). 
$clonedClass = $row->id == null ? 'cloned' : ''; 
?>

<!--ROW TO ADD-->
<div class="row layout-row <?=$clonedClass?>">
    <?php foreach ($row->columns as $column) : ?>
        <?= $this->render('_column', ['column' => $column]); ?>
    <?php endforeach;?>
</div>
