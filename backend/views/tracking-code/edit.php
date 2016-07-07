<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TrackingCode */

$this->title = 'Upraviť merací kód' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Meriace kódy', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upraviť merací kód';
?>
<div class="tracking-code-update">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
