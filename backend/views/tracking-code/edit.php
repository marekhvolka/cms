<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TrackingCode */

$this->title = 'Upraviť meriaci kód' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Meriace kódy', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upraviť meriaci kód';
?>
<div class="tracking-code-update">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
