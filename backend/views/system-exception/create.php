<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SystemException */

$this->title = 'Vytvoriť hlásenie';
$this->params['breadcrumbs'][] = ['label' => 'Hlásenia', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-exception-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
