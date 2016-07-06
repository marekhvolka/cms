<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Template */

$this->title = 'Upraviť šablónu' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Šablóny', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upraviť šablónu';
?>
<div class="template-update">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
