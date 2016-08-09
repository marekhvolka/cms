<?php

use yii\helpers\Html;
use yii\grid\GridView;
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
                'label'=>'Názov',
                'format' => 'raw',
                'value'=>function ($dataProvider) {
                    return Html::a($dataProvider->name, Url::to(['/post/edit/', 'id' => $dataProvider->id]));
                },
            ],
            'identifier',
            [
                'label' => 'Posledná zmena',
                'value' => function ($dataProvider) {
                    return $dataProvider->last_edit . ' (' .
                    (isset($dataProvider->lastEditUser) ? $dataProvider->lastEditUser->username : '') . ')';
                }
            ],
            'active:boolean',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
