<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $allVariables \backend\models\ProductVar */

$this->title = $model->isNewRecord ? 'Pridať nový produkt' : (isset($_GET['duplicate']) ? 'Duplikovať produkt: ' . $model->name : 'Editovať produkt: ' . ' ' . $model->name);
$this->params['breadcrumbs'][] = ['label' => 'Produkty', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Pridať' : (isset($_GET['duplicate']) ? 'Duplikovať' : 'Upraviť ' . $model->name);
?>
<div class="product-update">
    <?= $this->render('_form', [
        'model' => $model,
        'allVariables' => $allVariables,
    ]) ?>
</div>
