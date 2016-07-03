<?php
use backend\components\TreeGrid\TreeGridWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PageSearch */
/* @var $pages \backend\models\Page */
/* @var $pagination \yii\data\Pagination */

$this->title = 'Podstránky';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('button'); ?>
<?= Html::a('Pridať podstránku', ['edit'], ['class' => 'btn btn-success pull-right']) ?>
<?php $this->endBlock(); ?>


<div class="page-index">

    <?= $this->render('_search', [
        'model' => $searchModel,
    ]) ?>

    <?= TreeGridWidget::widget([
        'rows' => $pages,
        'columns' => [
            [
                'label' => 'Podstránka',
                'value' => function ($data) {
                    return Html::a($data->name, Url::to(['edit', 'id' => $data->id]));
                },
                'size' => '4'
            ],
            [
                'label' => 'Url',
                'value' => 'url',
                'size' => '3',
            ],
            [
                'label' => 'Vyparsovana',
                'value' => 'parsed',
                'size' => '1',
            ],
//            [
//                'label' => 'Aktívna',
//                'value' => 'active',
//                'size' => '1',
//            ],
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
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                        Url::to(['delete', 'id' => $data->id])) .
                    Html::a('<span class="fa fa-eye"></span>', Url::to(['show', 'id' => $data->id]));
                },
                'size' => 1
            ]
        ],
        'childrenIdentifier' => 'pages'
    ]) ?>
</div>
