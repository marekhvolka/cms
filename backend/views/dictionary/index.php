<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\DictionarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Slovník';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dictionary-index">

    <p>
        <?= Html::a('Vytvoriť slovník', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_search', [
        'model' => $searchModel,
    ]) ?>
    <?php Pjax::begin(['id' => 'gridData']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'identifier',
            'last_edit',
            [
                'label' => 'Naposledy editoval',
                'value' => 'last_edit_user.username'
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]); ?>
    <?php Pjax::end() ?>
</div>
