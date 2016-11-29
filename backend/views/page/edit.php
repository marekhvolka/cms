<?php

use backend\components\MultimediaWidget\MultimediaWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Page */

$this->title = $model->isNewRecord ? 'Pridať novú podstránku' : (isset($_GET['duplicate']) ? 'Duplikácia podstránky: ' . $model->breadcrumbs : 'Úprava podstránky: ' . ' ' . $model->breadcrumbs);
$this->params['breadcrumbs'][] = ['label' => 'Podstránky', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Pridať' : (isset($_GET['duplicate']) ? 'Duplikovať' : 'Upraviť ' . $model->breadcrumbs);

?>
<?= MultimediaWidget::widget(['renderAsModal' => true]) ?>
<div class="page-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
