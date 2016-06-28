<?php

use backend\models\VarType;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Snippet */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="snippet-form">

    <?php $form = ActiveForm::begin([
        'id' => 'dynamic-form',
        //'enableAjaxValidation' => true,
    ]); ?>

    <h3 class="page-header">Všeobecné
        <small>nastavenia</small>
    </h3>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>
                    Alternatívy
                    <a class="btn btn-success btn-xs btn-add-snippet-code pull-right" data-prefix="">
                        <i class="fa fa-plus"></i>
                    </a>
                </h4>
            </div>
            <div class="panel-body snippet-codes">
                <?php foreach ($model->snippetCodes as $indexCode => $snippetCode): ?>
                    <?= $this->render('_code', [
                        'model' => $snippetCode,
                        'form' => $form,
                        'prefix' => "SnippetCode[$indexCode]"
                    ]); ?>

                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?= $form->field($model, 'description')->textarea(['rows' => '4']) ?>

    <?= $this->render('_blocks-and-sections', ['model' => $model]); ?>

    <div class="form-group snippet-vars">
        <div class="panel panel-default">
            <div class="panel-heading form-inline">
                <h4>
                    Premenné
                    <a class="btn btn-success btn-xs btn-add-snippet-var pull-right" data-prefix="SnippetVar">
                        <i class="fa fa-plus"></i>
                    </a>
                </h4>
            </div>
            <div class="panel-body snippet-vars-container">
                <?php foreach ($model->snippetFirstLevelVars as $indexVar => $snippetVar): ?>
                    <?= $this->render('_variable', [
                        'model' => $snippetVar,
                        'prefix' => "SnippetVar[$indexVar]"
                    ]); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="navbar-fixed-bottom">
        <div class="col-sm-10 col-sm-offset-2">
            <div class="form-group">
                <?= Html::submitButton('Uložiť', [
                    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                    'id' => 'submit-btn'
                ]) ?>

                <?= Html::submitButton('Uložiť a pokračovať', [
                    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                    'id' => 'submit-btn',
                    'name' => 'continue'
                ]) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$controllerUrl = Url::to(['/snippet']);
$listIdJs = VarType::find()->where(['identifier' => 'list'])->one()->id;

$js = <<<JS

var listId = $listIdJs;
var controllerUrl = '$controllerUrl';

JS;

$this->registerJs($js, View::POS_BEGIN);
$this->registerJsFile('@web/js/snippets.js', [
    'depends' => [\yii\web\JqueryAsset::className()]
]);
?>

