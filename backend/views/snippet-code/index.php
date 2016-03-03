<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SnippetCodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Snippet Codes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="snippet-code-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Snippet Code', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'code:ntext',
            'popis:ntext',
            'portal',
            // 'snippet_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
