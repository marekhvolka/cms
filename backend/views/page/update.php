<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Page */
/* @var $headerSections \backend\models\Section */
/* @var $footerSections \backend\models\Section */

$this->title = 'Update Page: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="page-update">

    
    <?= $this->render('_form', [
        'model' => $model,
        'headerSections' => $headerSections,
        'footerSections' => $footerSections,
        'contentSections' => $contentSections,
        'sidebarSections' => $sidebarSections
    ]) ?>

</div>
