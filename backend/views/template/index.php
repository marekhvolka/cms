<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Šablóny';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('button'); ?>
<?= Html::a('Pridať šablónu', ['create'], ['class' => 'btn btn-success pull-right']) ?>
<?php $this->endBlock(); ?>

<div class="template-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Názov',
                'format' => 'raw',
                'value'=>function ($dataProvider) {
                    return Html::a($dataProvider->name,Url::to(['/template/update/', 'id' => $dataProvider->id]));
                },
            ],
            'active',
            'last_edit',
            [
                'label' => 'Naposledy editoval',
                'value' => 'lastEditUser.username'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
