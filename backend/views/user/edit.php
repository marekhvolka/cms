<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'Upraviť užívateľa: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Užívatelia', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upraviť užívateľa';
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
