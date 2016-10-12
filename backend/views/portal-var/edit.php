<?php

/* @var $this yii\web\View */
/* @var $model backend\models\PortalVar */

$this->title = $model->isNewRecord ? 'Pridať novú premennú' : 'Editovať premennú portálu: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Portálové premenné', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Pridať' : 'Upraviť ' . $model->name;
?>
<div class="portal-var-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
