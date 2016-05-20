<?php

use backend\models\DictionaryTranslation;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Dictionary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dictionary-form">

    <?php $form = ActiveForm::begin(); ?>

    <h3>Identifikátor</h3>
    <?= $form->field($model, 'identifier')->textInput(['maxlength' => true])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Vytvoriť' : 'Uložiť', ['class' => $model->isNewRecord ? 'btn 
        btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if (!$model->isNewRecord): ?>
        <h3>Preklady</h3>

        <?php
        /** @var \backend\models\Language $language */
        foreach (\backend\models\Language::find()->all() as $language) {
            /** @var DictionaryTranslation $translation */
            $translation = DictionaryTranslation::findOne(['language_id' => $language->id, 'word_id' => $model->id]);

            if (!$translation) {
                $translation = new DictionaryTranslation();
            }
            ?>
            <?php $form = ActiveForm::begin(
                ['action' =>
                     ['update',
                         'id'                => $model->id,
                         'updateTranslation' => $translation->id]
                ]); ?>

            <div class="form-group translation">
                <div class="input-group">
                    <span class="input-group-addon">
                        <?= $language->name ?>
                    </span>
                    <?= $form->field($translation, 'translation')->textInput(['class' => 'form-control 
                    dictionary-translation-control'])
                        ->label(false) ?>
                    <?= $form->field($translation, 'language_id')->hiddenInput(['value' => $language->id])->label(false) ?>
                </div>

                <?= Html::submitButton($model->isNewRecord ? 'Vytvoriť' : 'Uložiť', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        <?php } ?>
    <?php endif; ?>
</div>
