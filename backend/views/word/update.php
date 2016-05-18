<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Word */
/* @var $modelsWordTranslation backend\models\WordTranslation */

$this->title = 'Upraviť slovo: ' . ' ' . $model->identifier;
$this->params['breadcrumbs'][] = ['label' => 'Slovník', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dictionary-update">

    
    <?= $this->render('_form', [
        'model' => $model,
        'modelsWordTranslation' => $modelsWordTranslation,
    ]) ?>

</div>
