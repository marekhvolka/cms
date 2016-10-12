<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PostTag */

$this->title = $model->isNewRecord ? 'Pridať nový tag' : 'Upraviť tag: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tagy článkov', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Pridať' : 'Upraviť ' . $model->name;
?>
<div class="post-tag-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
