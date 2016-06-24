<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Portal */
/* @var $allVariables \backend\models\PortalVar */

$this->title = 'Editácia portálu: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Portály', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Úprava';
?>
<div class="portal-update">

    
    <?= $this->render('_form', [
        'model' => $model,
        'allVariables' => $allVariables,
    ]) ?>

</div>
