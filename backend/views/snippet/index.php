<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SnippetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Snippety';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('button'); ?>
<?= Html::a('Pridať snippet', ['edit'], ['class' => 'btn btn-success pull-right']) ?>
<?php $this->endBlock(); ?>

<div class="snippet-index">

    <?= $this->render('_search', [
        'model' => $searchModel,
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Názov',
                'format' => 'raw',
                'value'=>function ($dataProvider) {
                    return Html::a($dataProvider->name, Url::to(['/snippet/edit/', 'id' => $dataProvider->id]));
                },
            ],
            'description',
            [
                'label' => 'Posledná zmena',
                'value' => function ($dataProvider) {
                    return $dataProvider->last_edit . ' (' .
                    (isset($dataProvider->lastEditUser) ? $dataProvider->lastEditUser->username : '') . ')';
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
