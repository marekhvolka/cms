<?php

use backend\components\IdentifierGenerator\IdentifierGenerator;
use backend\models\WordTranslation;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Word */
/* @var $form yii\widgets\ActiveForm */
?>

<?php

function generate_form_for_language($index, $translation, $form)
{
    ?>
    <div class="form-group translation">
        <div class="input-group">
            <span class="input-group-addon">
                <?php echo $translation->language->name; ?>
            </span>
            <?= $form->field($translation, "[$index]translation")->textInput(['class' => 'form-control
                    dictionary-translation-control'])
                ->label(false)->error(['style' => "visiblity: none;"]) ?>
        </div>
    </div>
    <?php
}

?>

<div class="dictionary-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form',
        'enableAjaxValidation' => true,
    ]); ?>
    <h3>Preklad</h3>

<?php

    foreach ($model->translations as $index => $translation) {
        if ($translation->language->identifier == 'sk') {
            generate_form_for_language($index, $translation, $form);
        }
    };
?>

    <h3>Identifikátor</h3>
    <?= $form->field($model, 'identifier')->textInput(['maxlength' => true, 'readonly' => !$model->isNewRecord])
        ->label(false) ?>

    <?= IdentifierGenerator::widget([
        'idTextFrom' => 'wordtranslation-0-translation',
        'idTextTo'   => 'word-identifier',
        'delimiter'  => '_',
    ]) ?>

    <h3>Ostatné preklady</h3>

    <?php
    foreach ($model->translations as $index => $translation) {
        if ($translation->language->identifier != 'sk') {
            generate_form_for_language($index, $translation, $form);
        }
    }
    ?>

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

