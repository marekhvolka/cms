<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 15.05.16
 * Time: 0:31
 */
use yii\helpers\Html;

/* @var $pageBlock \backend\models\Block */

?>

<div class="btn-group column-page-block column-text <?=$pageBlock->id == null ? 'cloned-page-block' : '' ; // Check for existing pageBlock. If new created, is used for javascript cloning whole element and adding as new (dynamic adding). ?>" 
     data-content="" role="group">
    <button type="button" class="btn btn-default btn-sm" title="Nastavenie publikovania">
        <span class="glyphicon glyphicon-globe"></span>
    </button>

    <button type="button" id="" class="btn btn-default btn-sm text-content-btn">
        <?php echo $pageBlock->name; ?>
    </button>

    <?php if ($pageBlock->type == 'snippet') : ?>

    <?= Html::a(
            '<span class="glyphicon glyphicon-link"></span>',
            $pageBlock->snippetCode->url,
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
