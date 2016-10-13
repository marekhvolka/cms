<?php

use backend\components\MultimediaWidget\MultimediaWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */

$this->title = $model->isNewRecord ? 'Pridať nový článok' : (isset($_GET['duplicate']) ? 'Duplikácia článku: ' . $model->name : 'Úprava článku: ' . ' ' . $model->name);
$this->params['breadcrumbs'][] = ['label' => 'Články', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Pridať' : (isset($_GET['duplicate']) ? 'Duplikovať' : 'Upraviť ' . $model->name);
?>
<?= MultimediaWidget::widget(['renderAsModal' => true]) ?>
<div class="post-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
