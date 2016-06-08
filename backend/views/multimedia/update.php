<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MultimediaCategory */

$this->title = 'Upraviť multimediálnu kategóriu: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Multimédia', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="multimedia-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
