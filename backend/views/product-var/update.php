<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductVar */

$this->title = 'Upraviť premennú produktu: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Premenné produktu', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-var-update">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
