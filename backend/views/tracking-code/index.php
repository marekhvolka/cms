<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TrackingCodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Meracie kódy';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('button'); ?>
<?= Html::a('Pridať merací kód', ['create'], ['class' => 'btn btn-success pull-right']) ?>
<?php $this->endBlock(); ?>

<div class="tracking-code-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Názov',
                'format' => 'raw',
                'value'=>function ($dataProvider) {
                    return Html::a($dataProvider->name, Url::to(['/tracking-code/update/', 'id' => $dataProvider->id]));
                },
            ],
            [
                'label' => 'Umiestnenie',
                'value' => 'place.name'
            ],
            'active',
            'last_edit',
            [
                'label' => 'Naposledy editoval',
                'value' => 'lastEditUser.username'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
