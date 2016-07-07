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

    <h1>Chyba</h1>

    <h3>Súbor <?= $model->source_name ?></h3>

    <p><?= $model->source_code ?></p>


</div>
