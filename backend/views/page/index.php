<?php

use backend\components\TreeGrid\TreeGridWidget;
use yii\helpers\Html;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PageSearch */
/* @var $pages \backend\models\Page */
/* @var $pagination \yii\data\Pagination */

$this->title = 'Podstránky';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-index">

    <p>
        <?= Html::a('Pridať podstránku', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_search', [
        'model' => $searchModel,
    ]) ?>

    <?= TreeGridWidget::widget([
        'rows'               => $pages,
        'columns'            => [
            [
                'label' => 'Podstránka',
                'value' => 'name',
                'size'  => '5'
            ],
            [
                'label' => 'Url',
                'value' => 'url',
                'size' => '4'
            ],
            [
                'label' => 'Aktívna',
                'value' => 'active',
                'size' => '1'
            ],
            [
                'label' => 'Posledná zmena',
                'value' => 'last_edit',
                'size' => '2'
            ]
        ],
        'childrenIdentifier' => 'pages'
    ]) ?>
</div>
