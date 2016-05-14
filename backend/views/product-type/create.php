<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductType */

$this->title = 'Vytvoriť typ produktov';
$this->params['breadcrumbs'][] = ['label' => 'Typy produktov', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-type-create">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
