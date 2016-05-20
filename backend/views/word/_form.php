<?php

use backend\components\IdentifierGenerator\IdentifierGenerator;
use backend\models\WordTranslation;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Word */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dictionary-form">

    <?php $form = ActiveForm::begin(); ?>

    <h3>Identifikátor</h3>
    <?= $form->field($model, 'identifier')->textInput(['maxlength' => true])->label(false) ?>

    <?= IdentifierGenerator::widget([
        'idTextFrom' => 'wordtranslation-translation',
        'idTextTo'   => 'word-identifier',
        'delimiter'  => '_',
    ]) ?>

    <?php
    /** @var \backend\models\Language $language */
    foreach (\backend\models\Language::find()->all() as $language) {
        /** @var WordTranslation $translation */
        $translation = WordTranslation::findOne(['language_id' => $language->id, 'word_id' => $model->id]);

        if (!$translation) {
            $translation = new WordTranslation();
        }
        ?>
        <div class="form-group translation">
            <div class="input-group">
                <span class="input-group-addon">
                    <?= $language->name ?>
                </span>
                <?= $form->field($translation, 'translation')->textInput(['class' => 'form-control 
                    dictionary-translation-control', 'name' => 'translation[' . $language->id . ']'])
                    ->label(false)->error(['style' => "visiblity: none;"]) ?>
            </div>
        </div>
    <?php } ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Vytvoriť' : 'Uložiť', ['class' => $model->isNewRecord ? 'btn 
        btn-success' : 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>
</div>
