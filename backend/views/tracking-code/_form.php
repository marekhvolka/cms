<?php

use backend\models\TrackingCode;
use conquer\codemirror\CodemirrorAsset;
use conquer\codemirror\CodemirrorWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;


/* @var $this yii\web\View */
/* @var $model backend\models\TrackingCode */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tracking-code-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= CodemirrorWidget::widget([
            'name' => 'TrackingCode[code]',
            'value' => $model->code,
            'assets' => [
                CodemirrorAsset::MODE_CLIKE,
                CodemirrorAsset::KEYMAP_EMACS,
                CodemirrorAsset::ADDON_EDIT_MATCHBRACKETS,
                CodemirrorAsset::ADDON_COMMENT,
                CodemirrorAsset::ADDON_DIALOG,
                CodemirrorAsset::ADDON_SEARCHCURSOR,
                CodemirrorAsset::ADDON_SEARCH,
            ],
            'settings' => [
                'lineNumbers' => true,
                'mode' => 'text/x-csrc',
            ],
        ]
    ) ?>

    <?= $form->field($model, 'place_id')->dropDownList(
        ArrayHelper::map(TrackingCode::getPlaces(), 'id', 'name')
    ) ?>

    <?= $form->field($model, 'active')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]) ?>

    <div class="navbar-fixed-bottom">
        <div class="col-sm-10 col-sm-offset-2">
            <div class="form-group">
                <?= Html::submitButton('Uložiť', [
                    'class' => 'btn btn-primary',
                    'id' => 'submit-btn'
                ]) ?>

                <?= Html::submitButton('Uložiť a pokračovať', [
                    'class' => 'btn btn-info',
                    'id' => 'submit-btn',
                    'name' => 'continue'
                ]) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
