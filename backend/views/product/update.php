<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = 'Upraviť produkt: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Produkty', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-update">

    
    <?= $this->render('_form', [
        'model' => $model,
        'modelsProductVarValue' => $modelsProductVarValue,
        'allVariables' => $allVariables
    ]) ?>

</div>
