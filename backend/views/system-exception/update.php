<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SystemException */

$this->title = 'Update System Exception: ' . $model->identifier;
$this->params['breadcrumbs'][] = ['label' => 'System Exceptions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->identifier, 'url' => ['view', 'id' => $model->identifier]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="system-exception-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
