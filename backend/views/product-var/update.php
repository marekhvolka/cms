<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductVar */

$this->title = 'Update Product Var: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Product Vars', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-var-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
