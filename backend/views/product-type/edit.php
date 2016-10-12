<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductType */

$this->title = $model->isNewRecord ? 'Pridať nový typ produktu' : 'Upraviť typ produktu: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Typy produktov', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Pridať' : 'Upraviť ' . $model->name;
?>
<div class="product-type-update">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
