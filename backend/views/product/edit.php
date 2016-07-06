<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $allVariables \backend\models\ProductVar */

$this->title = 'Editovať produkt: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Produkty', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upraviť produkt';
?>
<div class="product-update">
    <?= $this->render('_form', [
        'model' => $model,
        'allVariables' => $allVariables,
    ]) ?>
</div>
