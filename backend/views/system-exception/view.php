<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SystemException */

$this->title = $model->identifier;
$this->params['breadcrumbs'][] = ['label' => 'System Exceptions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-exception-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->identifier], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->identifier], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'identifier',
            'time',
            'message:ntext',
        ],
    ]) ?>

</div>
