<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 15.05.16
 * Time: 0:31
 */
use yii\helpers\Html;

/* @var $block \backend\models\Block */

?>

<?php 
// Check for block existence. 
// If new created, is used for javascript cloning whole element and adding as new (dynamic adding). 
$clonedClass = $block->id == null ? 'cloned' : ''; 
?>

<div class="btn-group block <?=$block->id ?>"
     data-content="" role="group">
    <button type="button" class="btn btn-default btn-sm" title="Nastavenie publikovania">
        <span class="glyphicon glyphicon-globe"></span>
    </button>

    <button type="button" id="" class="btn btn-default btn-sm text-content-btn">
        <?php echo $block->name; ?>
    </button>

    <?php if (($block->type == 'snippet') && isset($block->snippetCode)) : ?>

    <?= Html::a(
            '<span class="glyphicon glyphicon-link"></span>',
            $block->snippetCode->url,
            [
                'class' => 'btn btn-info btn-sm',
                'title' => 'Upraviť snippet',
                'target' => '_blank'
            ]
        ) ?>

    <?php endif; ?>

    <button type="button" class="btn btn-danger btn-sm" title="Zmazať element">
        <span class="glyphicon glyphicon-remove"></span>
    </button>
</div>
