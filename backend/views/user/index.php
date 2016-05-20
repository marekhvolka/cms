<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Používatelia';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('button'); ?>
<?= Html::a('Pridať používateľa', ['create'], ['class' => 'btn btn-success pull-right']) ?>
<?php $this->endBlock(); ?>

<div class="user-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
            'email:email',
            'role',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
