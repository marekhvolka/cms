<?php

use backend\components\LayoutWidget\LayoutWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $sections backend\models\Section */
?>

<?php $form = ActiveForm::begin([
        'id' => 'form', 
        'enableAjaxValidation' => true,
        ]); ?>

<?= LayoutWidget::widget([
        'type' => 'footer', // TODO set type of layout.
        'sections' => $sections,
        'controllerUrl' => Url::to(['/layout']),
    ]
)?>

<div class="navbar-fixed-bottom">
    <div class="col-sm-10 col-sm-offset-2">
        <div class="form-group">
            <?= Html::submitButton('Uložiť', [
                'class' => 'btn btn-primary',
                'id' => 'submit-btn'
            ]) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php
//$url = Url::to(['portal/header-create']);
//
//$js = <<<JS
//
//var pageParams = {};
//
//pageParams.url = '$url';
//        
//JS;
//
//$this->registerJs($js);
//$this->registerJsFile('@web/js/portal-elements.js', [
//    'position' => \yii\web\View::POS_END,
//    'depends' => [\yii\web\JqueryAsset::className()]
//    ]);
?>

