<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Redirect */

$this->title = $model->isNewRecord ? 'Pridať nové presmerovanie' : 'Upraviť presmerovanie: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Presmerovania', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Pridať' : 'Upraviť';
?>
<div class="redirect-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
