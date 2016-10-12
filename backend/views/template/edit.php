<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Template */

$this->title = $model->isNewRecord ? 'Pridať novú šablónu' : 'Upraviť šablónu' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Šablóny', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Pridať' : 'Upraviť ' . $model->name;
?>
<div class="template-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
