<?php

use yii\helpers\BaseHtml;
use yii\widgets\ActiveForm;
use backend\components\LayoutWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

<?= LayoutWidget::widget()?>

<?= BaseHtml::buttonInput('Save', [
    'id' => 'save-btn',
    'class' => 'btn btn-success btn-sm'
    ])?>

<?php
$url = Url::to(['portal/header-create']);

$js = <<<JS

var pageParams = {};

pageParams.url = '$url';
        
JS;

$this->registerJs($js);
$this->registerJsFile('@web/js/portal-elements.js');
?>

