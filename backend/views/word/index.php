<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Slovník';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('button'); ?>
<?= Html::a('Pridať slovo', ['edit'], ['class' => 'btn btn-success pull-right']) ?>
<?php $this->endBlock(); ?>

<div class="dictionary-index">

    <?= $this->render('_search', [
        'model' => $searchModel,
    ]) ?>
    <?php Pjax::begin(['id' => 'gridData']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Identifikátor',
                'format' => 'raw',
                'value'=>function ($dataProvider) {
                    return Html::a($dataProvider->identifier,Url::to(['/word/edit/', 'id' => $dataProvider->id]));
                },
            ],
            [
                'label' => 'Posledná zmena',
                'value' => function ($dataProvider) {
                    return $dataProvider->last_edit . ' (' .
                    (isset($dataProvider->lastEditUser) ? $dataProvider->lastEditUser->username : '') . ')';
                }
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{edit} {delete}'],
        ],
    ]); ?>
    <?php Pjax::end() ?>
</div>
