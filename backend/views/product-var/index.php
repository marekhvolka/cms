<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductVarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Premenné produktu';     // Title of site
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('button'); ?>
<?= Html::a('Pridať produktovú premennú', ['create'], ['class' => 'btn btn-success pull-right']) ?>
<?php $this->endBlock(); ?>

<div class="product-var-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Názov',
                'format' => 'raw',
                'value'=>function ($dataProvider) {
                    return Html::a($dataProvider->name,Url::to(['/product-var/update/', 'id' => $dataProvider->id]));
                },
            ],
            'identifier',
            [
                'label' => 'Typ',
                'value' => 'type.name'
            ],
            // 'product_type',
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
