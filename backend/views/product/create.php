<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = 'Vytvoriť produkt';
$this->params['breadcrumbs'][] = ['label' => 'Produkty', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    
    <?= $this->render('_form', [
        'model' => $model,
        'modelsProductVarValue' => $modelsProductVarValue,
    ]) ?>

</div>
