<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Slovník';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dictionary-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Pridať slovo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_search', [
        'model' => $searchModel,
    ]) ?>
    <?php Pjax::begin(['id' => 'gridData']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Identifikátor',
                'format' => 'raw',
                'value'=>function ($dataProvider) {
                    return Html::a($dataProvider->identifier,Url::to(['/word/update/', 'id' => $dataProvider->id]));
                },
            ],
            'last_edit',
            [
                'label' => 'Naposledy editoval',
                'value' => 'lastEditUser.username'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end() ?>

    <?php

    $this->registerJs(
        '$("document").ready(function(){
        $("#search-form").on("pjax:end", function() {
            $.pjax.reload({container:"#gridData"});  //Reload GridView
        });
    });'
    );
    ?>

    <script>


        $('form').bind('input', function(event) {
        //input.addEventListener('input', function(event) {
            var container = $(this).closest('[data-pjax-container]');
            $.pjax.submit(event, container);
        })
    </script>

</div>
