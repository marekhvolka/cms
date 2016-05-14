<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PortalVarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Portal Vars';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portal-var-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Portal Var', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Názov',
                'format' => 'raw',
                'value'=>function ($dataProvider) {
                    return Html::a($dataProvider->name, Url::to(['/portal-var/update/', 'id' => $dataProvider->id]));
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
