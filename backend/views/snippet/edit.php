<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Snippet */

$this->title = 'Úprava snippetu: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Snippety', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="snippet-update">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
