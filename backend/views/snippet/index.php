<?php

use yii\helpers\Html;
use yii\grid\GridView;

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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Názov',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a($data->name,'?r=snippet/update&id='. $data->id);
                },
            ],
            'popis',
            'last_edit',
            [
                'label' => 'Naposledy editoval',
                'value' => 'lastEditUser.name'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
