<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dictionary */

$this->title = 'Create Dictionary';
$this->params['breadcrumbs'][] = ['label' => 'Dictionaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dictionary-create">

    
    <?= $this->render('_form', [
        'model' => $model,
        'modelsWordTranslation' => $modelsWordTranslation,
    ]) ?>

</div>
