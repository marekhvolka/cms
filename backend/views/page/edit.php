<?php

use backend\components\MultimediaWidget\MultimediaWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Page */

$this->title = 'Úprava podstránky: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Podstránky', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];

?>
<?= MultimediaWidget::widget(['renderAsModal' => true, 'onlyImages' => true]) ?>
<div class="page-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
