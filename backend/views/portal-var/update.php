<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PortalVar */

$this->title = 'Editovať premennú portálu: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Portal Vars', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="portal-var-update">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
