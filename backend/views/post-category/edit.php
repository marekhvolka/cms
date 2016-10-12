<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PostCategory */

$this->title = $model->isNewRecord ? 'Pridať novú kategóriu' : 'Upraviť kategóriu: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Kategórie článkov', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Pridať' : 'Upraviť ' . $model->name;
?>
<div class="post-category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
