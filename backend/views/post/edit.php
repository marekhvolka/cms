<?php

use backend\components\MultimediaWidget\MultimediaWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */

$this->title = $model->isNewRecord ? 'Pridať nový článok' : 'Upraviť článok: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Články', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Pridať' : 'Upraviť ' . $model->name;
?>
<?= MultimediaWidget::widget(['renderAsModal' => true]) ?>
<div class="post-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
