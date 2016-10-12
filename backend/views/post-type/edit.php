<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PostType */

$this->title = $model->isNewRecord ? 'Pridať nový typ článku' : 'Upraviť typ článku: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Typy článkov', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Pridať' : 'Upraviť ' . $model->name;
?>
<div class="post-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
