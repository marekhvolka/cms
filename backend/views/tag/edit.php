<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Tag */

$this->title = 'Upraviť tag: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upraviť';
?>
<div class="tag-update">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
