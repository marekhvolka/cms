<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\User;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Podstránky';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('button'); ?>
<?= Html::a('Pridať podstránku', ['create'], ['class' => 'btn btn-success pull-right']) ?>
<?php $this->endBlock(); ?>
<div class="page-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


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
                'value'=>function ($dataProvider) {
                    return Html::a($dataProvider->name,Url::to(['/page/update/', 'id' => $dataProvider->id]));
                },
            ],
            'url',
            [
                'label' => 'Rodič',
                'value' => 'parent.name'
            ],
            'active:boolean',
            [
                'label' => 'Posledná zmena',
                'value' => function ($dataProvider) {
                    return $dataProvider->last_edit . ' (' .
                    (isset($dataProvider->lastEditUser) ? $dataProvider->lastEditUser->username : '') . ')';
                }
            ],
        ],
    ]); ?>

</div>
