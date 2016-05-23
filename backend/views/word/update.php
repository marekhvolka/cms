<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Word */
/* @var $translations backend\models\WordTranslation[] */

$this->title = 'Upraviť preklad';
$this->params['breadcrumbs'][] = ['label' => 'Slovník', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upraviť preklad';
?>
<div class="dictionary-update">
    <?= $this->render('_form', [
        'model' => $model,
        'translations' => $translations,
    ]) ?>
</div>
