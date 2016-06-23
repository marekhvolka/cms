<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Snippet */

$this->title = 'Update Snippet: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Snippets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="snippet-update">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
