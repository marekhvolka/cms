<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PortalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Portals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portal-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Portal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Názov',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a($data->name,'?r=portal/update&id='. $data->id);
                },
            ],
            'language_id',
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
