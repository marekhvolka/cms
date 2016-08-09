<?php

use backend\components\TreeGrid\TreeGridWidget;
use yii\helpers\Html;
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
        'rows' => $products,
        'columns' => [
            [
                'label' => 'Produkt',
                'value' => function ($data) {
                    return Html::a($data->name, Url::to(['edit', 'id' => $data->id]));
                },
                'size' => '3'
            ],
            [
                'label' => 'Typ produktu',
                'value' => 'productTypeName',
                'size' => '2',
            ],
            [
                'label' => 'Typ spolupráce',
                'value' => 'partnershipTypeName',
                'size' => '2',
            ],
            [
                'label' => 'Posledná zmena',
                'value' => function ($data) {
                    return $data->last_edit . ' (' .
                    (isset($data->lastEditUser) ? $data->lastEditUser->username : '') . ')';
                },
                'size' => '3',
            ],
            [
                'label' => 'Akcie',
                'value' => function ($data) {
                    $result = '';
                    $result .= Html::a('<span class="fa fa-files-o"></span>',
                        Url::to(['edit', 'id' => $data->id, 'duplicate' => true]), [
                            'target' => '_blank'
                        ]);

                    $result .= Html::a('<span class="glyphicon glyphicon-trash"></span>',
                        Url::to(['delete', 'id' => $data->id], ['data-method' => 'post']));

                    /*if ($data->getProducts()->count() == 0) {
                        $result .= Html::a('<a class="glyphicon glyphicon-trash" data-confirm="Skutočne chcete odstrániť tento produkt (' . $data->name . ')?" data-method="post" data-pjax="0"></a>',
                            Url::to(['delete', 'id' => $data->id]));
                    }*/
                    return $result;
                },
                'size' => 1
            ]
        ],
        'childrenIdentifier' => 'products'
    ]) ?>
</div>
