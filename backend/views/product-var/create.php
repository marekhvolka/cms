<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductVar */

$this->title = 'Vytvoriť premennú produktu';
$this->params['breadcrumbs'][] = ['label' => 'Premenné produktu', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-var-create">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
