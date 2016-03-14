<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TrackingCode */

$this->title = 'Create Tracking Code';
$this->params['breadcrumbs'][] = ['label' => 'Tracking Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tracking-code-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
