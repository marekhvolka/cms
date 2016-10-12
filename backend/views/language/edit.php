<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Language */

$this->title = $model->isNewRecord ? 'Pridať jazyk' : 'Editovať jazyk: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Jazyky', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Pridať' : 'Upraviť ' . $model->name;
?>
<div class="language-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
