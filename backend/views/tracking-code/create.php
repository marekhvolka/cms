<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TrackingCode */

$this->title = 'Create Tracking Code';
$this->params['breadcrumbs'][] = ['label' => 'Tracking Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tracking-code-create">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
