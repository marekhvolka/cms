<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Tag */

$this->title = 'Vytvoriť Tag';
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-create">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
