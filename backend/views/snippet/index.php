<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SnippetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Snippets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="snippet-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Snippet', ['create'], ['class' => 'btn btn-success']) ?>
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
                'value'=>function ($dataProvider) {
                    return Html::a($dataProvider->name, Url::to(['/snippet/update/', 'id' => $dataProvider->id]));
                },
            ],
            'description',
            'last_edit',
            [
                'label' => 'Naposledy editoval',
                'value' => 'lastEditUser.username'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
