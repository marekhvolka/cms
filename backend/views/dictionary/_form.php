<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dictionary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dictionary-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'word')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'identifier')->textInput(['maxlength' => true]) ?>

    <div class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Premenné portálu</h4></div>
        <div class="panel-body">

            <div class="container-items"><!-- widgetContainer -->
                <?php foreach ($modelsWordTranslation as $i => $modelWordTranslation): ?>
                    <div class="item panel panel-default"><!-- widgetBody -->
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <?= $form->field($modelPortalVarValue, '[{$i}]attr_id')->dropDownList(
                                        ArrayHelper::map(PortalVar::find()->all(), 'id', 'vlastnost')
                                    ) ?>
                                </div>
                                <div class="col-sm-6">
                                    <?= $form->field($modelWordTranslation, "[{$i}]value")->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-sm-3">
                                    <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                    <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <?php
                            // necessary for update action.
                            if (! $modelPortalVarValue->isNewRecord) {
                                echo Html::activeHiddenInput($modelPortalVarValue, "[{$i}]id");
                            }
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>

    <div class="navbar-fixed-bottom">
        <div class="col-sm-10 col-sm-offset-2">
            <div class="form-group">
                <?= Html::submitButton('Uložiť', [
                    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                    'id' => 'submit-btn'
                ]) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
