<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Portal */
/* @var $allVariables \backend\models\PortalVar */

$this->title = $model->isNewRecord ? 'Pridať nový portál' : 'Editácia portálu: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Portály', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Pridať' : 'Upraviť ' . $model->name;
?>
<div class="portal-update">

    <?= $this->render('_form', [
        'model' => $model,
        'allVariables' => $allVariables,
    ]) ?>

</div>
