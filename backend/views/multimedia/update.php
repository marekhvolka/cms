<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MultimediaCategory */

$this->title = 'Upraviť multimediálnu kategóriu: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Multimédia', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = 'Upraviť';
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
