<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PortalVarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Portálové premenné';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('button'); ?>
<?= Html::a('Pridať portálovú premennú', ['create'], ['class' => 'btn btn-success pull-right']) ?>
<?php $this->endBlock(); ?>

<div class="portal-var-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Názov',
                'format' => 'raw',
                'value' => function ($dataProvider) {
                    return Html::a($dataProvider->name, Url::to(['/portal-var/update/', 'id' => $dataProvider->id]));
                },
            ],
            'identifier',
            [
                'label' => 'Typ premennej',
                'value' => 'type.name'
            ],
            'description:ntext',
            // 'last_edit',
            // 'last_edit_user',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
