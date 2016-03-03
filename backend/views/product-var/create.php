<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductVar */

$this->title = 'Create Product Var';
$this->params['breadcrumbs'][] = ['label' => 'Product Vars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-var-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
