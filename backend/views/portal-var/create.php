<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PortalVar */

$this->title = 'Create Portal Var';
$this->params['breadcrumbs'][] = ['label' => 'Portal Vars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portal-var-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
