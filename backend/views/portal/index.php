<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PortalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Portály';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('button'); ?>
<?= Html::a('Premenné', Url::to(['portal-var/index']), ['class' => 'btn btn-primary pull-right']) ?>
<?= Html::a('Pridať portál', ['edit'], ['class' => 'btn btn-success pull-right']) ?>
<?php $this->endBlock(); ?>

<div class="portal-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Názov',
                'format' => 'raw',
                'value'=>function ($dataProvider) {
                    return Html::a($dataProvider->name, Url::to(['/portal/edit/', 'id' => $dataProvider->id]));
                },
            ],
            [
                'label' => 'Krajina',
                'value' => 'language.name'
            ],
            'domain',
            [
                'label' => 'Šablóna',
                'value' => 'template.name'
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
