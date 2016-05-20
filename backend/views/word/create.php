<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Word */
/* @var $languages backend\models\Language[] */
/* @var $defaultLanguage backend\models\Language */

$this->title = 'Pridať preklad';
$this->params['breadcrumbs'][] = ['label' => 'Slovník', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dictionary-create">
    <?= $this->render('_form', [
        'model' => $model,
        'languages' => $languages,
        'defaultLanguage' => $defaultLanguage
    ]) ?>
</div>
