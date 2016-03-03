<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Portal */

$this->title = 'Create Portal';
$this->params['breadcrumbs'][] = ['label' => 'Portals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsPortalVarValue' => $modelsPortalVarValue,
    ]) ?>

</div>
