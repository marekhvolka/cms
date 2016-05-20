<?php

use backend\components\TreeGrid\TreeGridWidget;
use yii\helpers\Html;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PageSearch */
/* @var $pages \backend\models\Page */

$this->title = 'Podstránky';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Pridať podstránku', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_search', [
        'model' => $searchModel,
    ]) ?>

    <?= TreeGridWidget::widget([
        'rows' => $pages,
        'columns' => [
            [
                'label' => 'Podstránka',
                'value' => 'name'
            ],
            [
            'label' => 'Url',
            'value' => 'url'
            ],
            [
                'label' => 'Aktívna',
                'value' => 'active'
            ],
            [
                'label' => 'Posledná zmena',
                'value' => 'last_edit'
            ]
        ],
        'childrenIdentifier' => 'pages'
    ])?>

</div>
