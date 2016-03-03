<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Page */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'url:url',
            'portal_id',
            'active',
            'in_menu',
            'parent_id',
            'poradie',
            'product_id',
            'presmerovanie',
            'utm',
            'presmerovanie_aktivne',
            'seo_title',
            'seo_description',
            'seo_keywords',
            'layout_poradie',
            'layout_poradie_id',
            'layout_element:ntext',
            'layout_element_type:ntext',
            'layout_element_active:ntext',
            'layout_element_time_from:ntext',
            'layout_element_time_to:ntext',
            'layout_color_scheme',
            'sidebar',
            'sidebar_side',
            'sidebar_size',
            'footer',
            'header',
            'last_edit',
            'last_edit_user',
        ],
    ]) ?>

</div>
