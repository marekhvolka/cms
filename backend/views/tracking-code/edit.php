<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TrackingCode */

$this->title = $model->isNewRecord ? 'Pridať nový merací kód' : 'Upraviť merací kód' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Meriace kódy', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Pridať' : 'Upraviť ' . $model->name;
?>
<div class="tracking-code-update">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
