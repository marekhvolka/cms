<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Multimédia';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('button'); ?>
<?= Html::a('Pridať kategóriu', ['create'], ['class' => 'btn btn-success pull-right']) ?>
<?php $this->endBlock(); ?>

<div class="multimedia-index">

    <h2>Kategórie</h2>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'  => 'Meno',
                'format' => 'raw',
                'value'  => function ($dataProvider) {
                    return Html::a($dataProvider->name, Url::to(['/multimedia/files/', 'name' => $dataProvider->name]));
                },
            ],

            [
                'class'      => 'yii\grid\ActionColumn',
                'template'   => '{update} {delete}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    $url = Url::to([$action, 'name' => $model->name]);

                    return $url;
                }
            ],
        ],
    ]); ?>

</div>
