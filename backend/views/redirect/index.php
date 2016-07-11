<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\RedirectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Presmerovania';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="redirect-index">

    <?php $this->beginBlock('button'); ?>
    <?= Html::a('Pridať presmerovanie', ['edit'], ['class' => 'btn btn-success pull-right']) ?>
    <?php $this->endBlock(); ?>

    <?= $this->render('_search', [
        'model' => $searchModel,
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'ID',
                'format' => 'raw',
                'value' => function ($dataProvider) {
                    return Html::a($dataProvider->id, Url::to(['/redirect/edit/', 'id' => $dataProvider->id]));
                },
            ],
            'source_url:ntext',
            'target_url:ntext',
            'redirect_type',
            'active:boolean',
            [
                'label' => 'Posledná zmena',
                'value' => function ($dataProvider) {
                    return $dataProvider->last_edit . ' (' .
                    (isset($dataProvider->lastEditUser) ? $dataProvider->lastEditUser->username : '') . ')';
                }
            ],
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
