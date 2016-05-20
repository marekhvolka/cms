<?php

use backend\components\IdentifierGenerator\IdentifierGenerator;
use backend\models\WordTranslation;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Word */
/* @var $languages backend\models\Language[] */
/* @var $defaultLanguage backend\models\Language */
/* @var $form yii\widgets\ActiveForm */
?>

<?php

function generate_form_for_language($language, $form, $word)
{
    $translation = $word->getTranslation($language->id);

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
    <?php
}

?>

<div class="dictionary-form">

    <?php $form = ActiveForm::begin(); ?>
    <h3>Preklad</h3>

    <?php generate_form_for_language($defaultLanguage, $form, $model) ?>

    <h3>Identifikátor</h3>
    <?= $form->field($model, 'identifier')->textInput(['maxlength' => true])->label(false) ?>

    <?= IdentifierGenerator::widget([
        'idTextFrom' => 'wordtranslation-translation',
        'idTextTo'   => 'word-identifier',
        'delimiter'  => '_',
    ]) ?>

    <h3>Ostatné preklady</h3>

    <?php
    foreach ($languages as $language) {
        if ($language != $defaultLanguage) {
            generate_form_for_language($language, $form, $model);
        }
    }
    ?>

    <div class="navbar-fixed-bottom">
        <div class="col-sm-10 col-sm-offset-2">
            <div class="form-group">
                <?= Html::submitButton('Uložiť', [
                    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                    'id'    => 'submit-btn'
                ]) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

