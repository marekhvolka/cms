<?php
use backend\components\TreeGrid\TreeGridWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PageSearch */
/* @var $pages \backend\models\Page */
/* @var $pagination \yii\data\Pagination */

$this->title = 'Podstránky';
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $this->beginBlock('button'); ?>

<?php $result = \backend\controllers\BaseController::$portal->getOutdatedPageCount(); ?>

<strong> Počet neaktuálných: <?= $result['outdated'] ?>/<?= $result['count'] ?></strong>
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
                'label' => 'Neaktuálna',
                'value' => 'outdated',
                'size' => '1',
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

                    $result .= Html::a('<span class="fa fa-eye"></span>', Url::to(['show', 'id' => $data->id]), [
                        'target' => '_blank'
                    ]);

                    $result .= Html::a('<span class="fa fa-files-o"></span>', Url::to(['edit', 'id' => $data->id, 'duplicate' => true]), [
                        'target' => '_blank'
                    ]);

                    if ($data->getPages()->count() == 0) {
                        $result .= ' ' . Html::a('<a class="glyphicon glyphicon-trash" data-confirm="Skutočne chcete odstrániť túto stránku (' . $data->name . ')?" data-method="post" data-pjax="0"></a>',
                                Url::to(['delete', 'id' => $data->id]));
                    }

                    return $result;
                },
                'size' => 1
            ]
        ],
        'childrenIdentifier' => 'pages'
    ]) ?>
</div>
