<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SnippetCode */

$this->title = 'Create Snippet Code';
$this->params['breadcrumbs'][] = ['label' => 'Snippet Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="snippet-code-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
