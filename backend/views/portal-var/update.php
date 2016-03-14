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

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
