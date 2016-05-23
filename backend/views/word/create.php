<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Word */
/* @var $translations backend\models\WordTranslation[] */

$this->title = 'Pridať preklad';
$this->params['breadcrumbs'][] = ['label' => 'Slovník', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dictionary-create">
    <?= $this->render('_form', [
        'model' => $model,
        'translations' => $translations
    ]) ?>
</div>
