<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PortalVarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Portal Vars';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portal-var-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Portal Var', ['create'], ['class' => 'btn btn-success']) ?>
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
                    return Html::a($data->name,'?r=portal-var/update&id='. $data->id);
                },
            ],
            'identifier',
            'description:ntext',
            'type_id',
            // 'last_edit',
            // 'last_edit_user',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
