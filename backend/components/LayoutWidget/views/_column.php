<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 15.05.16
 * Time: 0:30
 */

/* @var $column backend\models\Column */

?>

<?php 
// Check for column existence. 
// If new created, is used for javascript cloning whole element and adding as new (dynamic adding). 
$clonedClass = $column->id == null ? 'cloned' : ''; 
?>

<!--COLUMN TO ADD-->
<div class="col-md-<?php echo $column->width; ?> panel panel-default column <?=$clonedClass?>" 
     data-options="{}">
    <div class="btn-group section-buttons">
        <div class="section-button">
            <button class="btn btn-primary options-btn btn-xs" data-toggle="modal" data-target="#modal-options">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </button>
        </div>
        <div class="dropdown dropdown-column-content section-button">
            <button type="button" class="btn btn-success dropdown-toggle add-row-btn btn-xs"
                    title="Vložiť nový blok" data-toggle="dropdown">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#" class="column-option text-option" data-toggle="modal" data-target="#modal-text">Text</a></li>
                <li><a href="#" class="column-option html-option">HTML</a></li>
                <li><a href="#" class="column-option smart-snippet-option">Smart snippet</a></li>
                <li><a href="#" class="column-option product-snippet-option">Produktový snippet</a></li>
                <li><a href="#" class="column-option portal-snippet-option">Portálový snippet</a></li>
            </ul>
        </div>
        <div class="section-button">
            <button type="button" class="btn btn-danger btn-xs btn-remove-row" title="Zmazať" >
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    <div class="panel-heading"><?php echo $column->order; ?>. stĺpec</div>
    <div class="panel-body">
        <ul class="column-elements">
            <?php foreach ($column->blocks as $block) : ?>
                <li>
                    <?= $this->render('_block', ['block' => $block]); ?>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>

