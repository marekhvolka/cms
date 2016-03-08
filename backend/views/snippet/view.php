<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Snippet */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Snippets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="snippet-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'popis',
            'default_code_id',
            'typ_snippet',
            'sekcia_id',
            'sekcia_class',
            'sekcia_style',
            'block_id',
            'block_class',
            'block_style',
            'last_edit',
            'last_edit_user',
        ],
    ]) ?>

</div>
