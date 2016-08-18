<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Upraviť užívateľa: ' . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Užívatelia', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upraviť užívateľa';
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
