<?php

use backend\components\TreeGrid\TreeGridWidget;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProductSearch */
/* @var $products \backend\models\Product */

$this->title = 'Produkty';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('button'); ?>
<?= Html::a('Pridať produkt', ['edit'], ['class' => 'btn btn-success pull-right']) ?>
<?php $this->endBlock(); ?>

<div class="product-index">

    <?= $this->render('_search', [
        'model' => $searchModel,
    ]) ?>
    <?= TreeGridWidget::widget([
        'rows'    => $products,
        'columns' => [
            [
                'label' => 'Produkt',
                'value' => function ($data) {
                    return Html::a($data->name, Url::to(['edit', 'id' => $data->id]));
                },
                'size'  => '4'
            ],
            [
                'label' => 'Typ produktu',
                'value' => 'productTypeName',
                'size'  => '3',
            ],
            [
                'label' => 'Aktívna',
                'value' => 'active',
                'size'  => '1',
            ],
            [
                'label' => 'Posledná zmena',
                'value' => function ($data) {
                    return $data->last_edit . ' (' .
                    (isset($data->lastEditUser) ? $data->lastEditUser->username : '') . ')';
                },
                'size'  => '3',
            ],
            [
                'label' => 'Akcie',
                'value' => function($data) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['delete', 'id' => $data->id]));
                },
                'size' => 1
            ]
        ],
        'childrenIdentifier' => 'products'
    ]) ?>
</div>
