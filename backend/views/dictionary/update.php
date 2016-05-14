<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dictionary */

$this->title = 'Update Dictionary: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dictionaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dictionary-update">

    
    <?= $this->render('_form', [
        'model' => $model,
        'modelsWordTranslation' => $modelsWordTranslation,
    ]) ?>

</div>
