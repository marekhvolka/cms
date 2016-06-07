<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Vytvoriť multimediálnu kategóriu';
$this->params['breadcrumbs'][] = ['label' => 'Multimédia', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="multimedia-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
