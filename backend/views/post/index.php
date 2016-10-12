<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Články';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <?php $this->beginBlock('button'); ?>
    <?= Html::a('Pridať článok', ['edit'], ['class' => 'btn btn-success pull-right']) ?>
    <?php $this->endBlock(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Názov',
                'format' => 'raw',
                'value' => function ($dataProvider) {
                    return Html::a($dataProvider->name, Url::to(['/post/edit/', 'id' => $dataProvider->id]));
                },
            ],
            [
                'label' => 'Kategória',
                'value' => 'postCategory.name'
            ],
            'published_at',
            [
                'label' => 'Posledná zmena',
                'value' => function ($dataProvider) {
                    return $dataProvider->last_edit . ' (' .
                    (isset($dataProvider->lastEditUser) ? $dataProvider->lastEditUser->username : '') . ')';
                }
            ],
            'active:boolean',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{show}{edit}{delete}',
                'buttons' => [
                    'show' => function ($url, $model) {
                        return Html::a('<span class="fa fa-eye"></span>', $url, [
                            'title' => Yii::t('yii', 'Náhľad'),
                        ]);

                    },
                    'edit' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('yii', 'Editácia'),
                        ]);

                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => Yii::t('yii', 'Zmazanie'),
                            'data' => [
                                'confirm' => 'Naozaj chcete zmazať článok ' . $model->name . '?',
                                'method' => 'post'
                            ]
                        ]);

                    }
                ]
            ],
        ],
    ]); ?>
</div>
