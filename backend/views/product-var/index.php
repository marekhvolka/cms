<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Premenné produktu';     // Title of site
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('button'); ?>
<?= Html::a('Pridať produktovú premennú', ['edit'], ['class' => 'btn btn-success pull-right']) ?>
<?php $this->endBlock(); ?>

<div class="product-var-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Názov',
                'format' => 'raw',
                'value' => function ($dataProvider) {
                    return Html::a($dataProvider->name, Url::to(['/product-var/edit/', 'id' => $dataProvider->id]));
                },
            ],
            'identifier',
            [
                'label' => 'Typ',
                'value' => 'type.name'
            ],
            [
                'label' => 'Posledná zmena',
                'value' => function ($dataProvider) {
                    return $dataProvider->last_edit . ' (' .
                    (isset($dataProvider->lastEditUser) ? $dataProvider->lastEditUser->username : '') . ')';
                }
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{delete}'],
        ],
    ]); ?>

</div>
