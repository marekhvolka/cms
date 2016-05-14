<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PortalVar */

$this->title = 'Vytvoriť premennú portálu';
$this->params['breadcrumbs'][] = ['label' => 'Portal Vars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portal-var-create">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
