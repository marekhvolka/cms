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

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
