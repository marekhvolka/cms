<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\SystemExceptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hlásenia';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-exception-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'Názov',
                'format' => 'raw',
                'value'=>function ($dataProvider) {
                    return Html::a($dataProvider->object->name, Url::to(['/system-exception/view/', 'id' => $dataProvider->id]));
                },
            ],
            'type',
            'time',
            'message:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action == 'update') {
                        $action = 'edit';
                    }
                    $params = is_array($key) ? $key : ['id' => (string)$key];
                    $params[0] = $action;

                    return Url::toRoute($params);
                },
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>
</div>
