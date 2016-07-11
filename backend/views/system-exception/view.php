<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\SystemExceptionSearch */
/* @var $model \backend\models\SystemException */

$this->title = 'Hlásenia';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-exception-index">

    <h1>Chyba <?= $model->object->name ?></h1>

    <h3>Súbor</h3>
    <p><?= $model->source_name ?></p>

    <h4>Chybová hláška</h4>
    <p><?= $model->message ?></p>
    <h4>Zdrojový kód</h4>
    <p><?= Yii::$app->dataEngine->printCode($model->source_code, $model->source_line) ?></p>
    <h4>Na riadku <strong><?= $model->source_line ?></strong></h4>
</div>
