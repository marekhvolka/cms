<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Page */
/* @var $headerSections \backend\models\Section */
/* @var $footerSections \backend\models\Section */
/* @var $sidebarSections \backend\models\Section */
/* @var $contentSections \backend\models\Section */

$this->title = 'Úprava podstránky: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Podstránky', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Úprava';
?>
<div class="page-update">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
