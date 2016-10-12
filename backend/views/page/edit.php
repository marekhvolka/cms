<?php

use backend\components\MultimediaWidget\MultimediaWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Page */

$this->title = $model->isNewRecord || (isset($_GET['duplicate'])) ? 'Pridať novú podstránku' : 'Úprava podstránky: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Podstránky', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord || (isset($_GET['duplicate'])) ? 'Pridať' : 'Upraviť ' . $model->name;

?>
<?= MultimediaWidget::widget(['renderAsModal' => true]) ?>
<div class="page-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
