<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Word */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dictionary-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'identifier')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <label for="slovo" class="col-sm-2 control-label">Preklad</label>
        <div class="col-sm-10">

            <?php foreach($modelsWordTranslation as $wordTranslation) : ?>
            <div class="input-group" style="margin: 10px 0px;">
                <span class="input-group-addon" id="basic-addon"><?= $wordTranslation->language->name ?></span>
                <input type="text" class="form-control" name="preklad[3]" value="<?= $wordTranslation->translation ?>"
                       placeholder="Preklad" aria-describedby="basic-addon">
            </div>
            <?php endforeach; ?>
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
