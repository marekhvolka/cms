<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SystemException */

$this->title = 'Upraviť hlásenie' . $model->identifier;
$this->params['breadcrumbs'][] = ['label' => 'Hlásenie', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upraviť';
?>
<div class="system-exception-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
