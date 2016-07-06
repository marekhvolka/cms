<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductType */

$this->title = 'Upraviť typ produktu: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Typy produktov', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upraviť typ produktu';
?>
<div class="product-type-update">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
