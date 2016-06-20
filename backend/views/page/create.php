<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Page */
/* @var $headerSections \backend\models\Section */
/* @var $footerSections \backend\models\Section */
/* @var $sidebarSections \backend\models\Section */
/* @var $contentSections \backend\models\Section */

$this->title = 'Pridanie podstránky';
$this->params['breadcrumbs'][] = ['label' => 'Podstránky', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
