<?php

/* @var $this yii\web\View */
/* @var $model backend\models\PortalVar */

$this->title = 'Editovať premennú portálu: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Portálové premenné', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upraviť premennú portálu';
?>
<div class="portal-var-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
