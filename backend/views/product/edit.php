<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $allVariables \backend\models\ProductVar */

$this->title = 'Editovať produkt: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Produkty', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-update">
    <?= $this->render('_form', [
        'model' => $model,
        'allVariables' => $allVariables,
    ]) ?>
</div>
