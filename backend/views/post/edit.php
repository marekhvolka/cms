<?php

use backend\components\MultimediaWidget\MultimediaWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */

$this->title = 'Update Post: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Články', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['edit', 'id' => $model->id]];
?>
<?= MultimediaWidget::widget(['renderAsModal' => true]) ?>
<div class="post-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
