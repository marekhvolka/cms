<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Word */

$this->title = $model->isNewRecord ? 'Pridať nové slovo' : 'Upraviť preklad';
$this->params['breadcrumbs'][] = ['label' => 'Slovník', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Pridať' : 'Upraviť ' . $model->identifier;
?>
<div class="dictionary-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
