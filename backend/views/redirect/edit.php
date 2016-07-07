<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Redirect */

$this->title = 'Upraviť presmerovanie: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Presmerovania', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upraviť';
?>
<div class="redirect-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
