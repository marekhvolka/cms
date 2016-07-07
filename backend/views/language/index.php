<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jazyky';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('button'); ?>
<?= Html::a('Pridať jazyk', ['edit'], ['class' => 'btn btn-success pull-right']) ?>
<?php $this->endBlock(); ?>

<div class="language-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Názov',
                'format' => 'raw',
                'value'=>function ($dataProvider) {
                    return Html::a($dataProvider->name,Url::to(['/language/edit/', 'id' => $dataProvider->id]));
                },
            ],
            'identifier',
            'active:boolean',

            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action == 'update') {
                        $action = 'edit';
                    }
                    $params = is_array($key) ? $key : ['id' => (string)$key];
                    $params[0] = $action;

                    return Url::toRoute($params);
                },
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>

</div>
