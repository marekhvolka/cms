<?php

use backend\components\IdentifierGenerator\IdentifierGenerator;
use backend\models\VarType;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PortalVar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="portal-var-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form',
        'enableAjaxValidation' => true,
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'identifier')->textInput(['maxlength' => true]) ?>

    <?=IdentifierGenerator::widget([
        'idTextFrom' => 'portalvar-name',
        'idTextTo' => 'portalvar-identifier',
        'delimiter' => '_',
    ])?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'type_id')->dropDownList(
        ArrayHelper::map(VarType::find()->all(), 'id', 'name')
    ) ?>

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
