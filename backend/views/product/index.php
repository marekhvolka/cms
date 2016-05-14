<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Produkty';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Vytvoriť produkt', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_search', [
        'model' => $searchModel,
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Názov',
                'format' => 'raw',
                'value'=>function ($dataProvider) {
                    return Html::a($dataProvider->name,Url::to(['/product/update/', 'id' => $dataProvider->id]));
                },
            ],
            [
                'label' => 'Rodič',
                'value' => 'parent.name'
            ],
            [
                'label' => 'Typ produktu',
                'value' => 'productType.name'
            ],
            'identifier',
            // 'popis',
            // 'language_id',
            // 'active',
            'last_edit',
            [
                'label' => 'Naposledy editoval',
                'value' => 'lastEditUser.username'
            ],
            ['class' => 'yii\grid\ActionColumn',
            'template' => '{delete}'],
        ],
    ]); ?>

</div>
