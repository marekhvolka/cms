<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Portal */

$this->title = 'Update Portal: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Portals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="portal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsPortalVarValue' => $modelsPortalVarValue,
    ]) ?>

</div>
