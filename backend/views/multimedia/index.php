<?php

use backend\assets\FancyBoxAsset;
use backend\components\MultimediaWidget\MultimediaWidget;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $data array */
/* @var $allSubcategories array */
/* @var $allCategories array */
/* @var $uploadFile \backend\models\MultimediaItem */

$this->title = 'Multimédia';
$this->params['breadcrumbs'][] = $this->title;

?>

<?= MultimediaWidget::widget() ?>
