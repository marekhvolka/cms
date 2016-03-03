<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Page', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_search', [
        'model' => $searchModel,
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Názov',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a($data->name,'?r=page/update&id='. $data->id);
                },
            ],
            'url',
            [
                'label' => 'Rodič',
                'value' => 'parent.name'
            ],
            'active',
            // 'in_menu',
            // 'parent_id',
            // 'poradie',
            // 'product_id',
            // 'presmerovanie',
            // 'utm',
            // 'presmerovanie_aktivne',
            // 'seo_title',
            // 'seo_description',
            // 'seo_keywords',
            // 'layout_poradie',
            // 'layout_poradie_id',
            // 'layout_element:ntext',
            // 'layout_element_type:ntext',
            // 'layout_element_active:ntext',
            // 'layout_element_time_from:ntext',
            // 'layout_element_time_to:ntext',
            // 'layout_color_scheme',
            // 'sidebar',
            // 'sidebar_side',
            // 'sidebar_size',
            // 'footer',
            // 'header',
            'last_edit',
            [
                'label' => 'Naposledy editoval',
                'value' => 'lastEditUser.name'
            ]
        ],
    ]); ?>

</div>
