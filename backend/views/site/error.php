<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">
    
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Chyba uvedená vyššie nastala pri spracovávaní Vašeho požiadavku.
    </p>
    <p>
        Prosíme Vás, kontaktujte nás v prípade, ak je to chyba servera. Ďakujeme Vám.
    </p>

</div>
