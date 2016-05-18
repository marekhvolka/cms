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

<?php $this->beginBlock('button'); ?>
<?= Html::a('Pridať slovo', ['create'], ['class' => 'btn btn-success pull-right']) ?>
<?php $this->endBlock(); ?>

<div class="dictionary-index">

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
