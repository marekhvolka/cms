<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Redirect */

$this->title = 'Upraviť presmerovanie: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Redirects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="redirect-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
