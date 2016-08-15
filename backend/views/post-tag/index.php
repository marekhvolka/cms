<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostTagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Post Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-tag-index">

    <?php $this->beginBlock('button'); ?>
    <?= Html::a('Pridať tag', ['edit'], ['class' => 'btn btn-success pull-right']) ?>
    <?php $this->endBlock(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Názov',
                'format' => 'raw',
                'value'=>function ($dataProvider) {
                    return Html::a($dataProvider->name, Url::to(['/post-tag/edit/', 'id' => $dataProvider->id]));
                },
            ],
            'identifier',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
