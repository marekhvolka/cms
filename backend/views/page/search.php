<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PortalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stránky';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('button'); ?>

<?php $result = \backend\controllers\BaseController::$portal->getOutdatedPageCount(); ?>

<strong> Počet neaktuálných: <?= $result['outdated'] ?>/<?= $result['count'] ?></strong>
<?= Html::a('Pridať podstránku', ['edit'], ['class' => 'btn btn-success pull-right']) ?>
<?php $this->endBlock(); ?>

<div class="portal-index">

    <?= $this->render('_search', [
        'model' => $searchModel,
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Podstránka',
                'value' => function ($data) {
                    return Html::a($data->name, Url::to(['edit', 'id' => $data->id]));
                },
                'format' => 'raw'
            ],
            'url:ntext',
            'outdated:boolean',
            [
                'label' => 'Posledná zmena',
                'value' => function ($data) {
                    return $data->last_edit . ' (' .
                    (isset($data->lastEditUser) ? $data->lastEditUser->username : '') . ')';
                },
                'format' => 'raw'
            ],
            [
                'label' => 'Akcie',
                'value' => function ($data) {
                    $result = '';

                    $result .= Html::a('<span class="fa fa-eye"></span>', Url::to(['show', 'id' => $data->id]), [
                        'target' => '_blank'
                    ]);

                    if ($data->getPages()->count() == 0) {
                        $result .= ' ' . Html::a('<a class="glyphicon glyphicon-trash" data-confirm="Skutočne chcete odstrániť túto stránku (' . $data->name . ')?" data-method="post" data-pjax="0"></a>',
                                Url::to(['delete', 'id' => $data->id]));
                    }

                    return $result;
                },
                'format' => 'raw'
            ]
        ],
    ]); ?>

</div>
