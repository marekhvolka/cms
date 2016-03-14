<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TrackingCode */

$this->title = 'Update Tracking Code: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tracking Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tracking-code-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
