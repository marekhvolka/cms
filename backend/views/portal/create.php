<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Portal */

$this->title = 'Create Portal';
$this->params['breadcrumbs'][] = ['label' => 'Portals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portal-create">

    
    <?= $this->render('_form', [
        'model' => $model,
        'modelsPortalVarValue' => $modelsPortalVarValue,
    ]) ?>

</div>
