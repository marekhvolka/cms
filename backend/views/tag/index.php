<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tag', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Systémový názov',
                'format' => 'raw',
                'value'=>function ($dataProvider) {
                    return Html::a($dataProvider->name, Url::to(['/tag/update/', 'id' => $dataProvider->id]));
                },
            ],
            'label',
            'identifier',
            'active',
            'last_edit',
            'last_edit_user',
            ['class' => 'yii\grid\ActionColumn',
            'template' => '{delete}'],
        ],
    ]); ?>

</div>
