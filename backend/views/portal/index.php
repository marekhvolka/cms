<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PortalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Portals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portal-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Portal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Názov',
                'format' => 'raw',
                'value'=>function ($dataProvider) {
                    return Html::a($dataProvider->name, Url::to(['/portal/update/', 'id' => $dataProvider->id]));
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
            // 'template_settings:ntext',
            // 'active',
            // 'publikovana',
            // 'cache',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
