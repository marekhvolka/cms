<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LanguageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Languages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="language-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Language', ['create'], ['class' => 'btn btn-success']) ?>
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
                    return Html::a($data->name,'?r=language/update&id='. $data->id);
                },
            ],
            'currency',
            'identifier',
            'active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
