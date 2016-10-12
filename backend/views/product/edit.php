<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $allVariables \backend\models\ProductVar */

$this->title = $model->isNewRecord || (isset($_GET['duplicate'])) ? 'Pridať nový produkt' : 'Editovať produkt: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Produkty', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord || (isset($_GET['duplicate'])) ? 'Pridať' : 'Upraviť ' . $model->name;
?>
<div class="product-update">
    <?= $this->render('_form', [
        'model' => $model,
        'allVariables' => $allVariables,
    ]) ?>
</div>
