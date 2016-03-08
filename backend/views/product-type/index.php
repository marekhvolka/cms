<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Typy produktov';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-type-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Vytvoriť typ produktu', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Názov',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a($data->name,'?r=product-type/update&id='. $data->id);
                },
            ],
            'active',
            [
                'label' => 'Naposledy editoval',
                'value' => 'lastEditUser.username'
            ],
            'last_edit',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
