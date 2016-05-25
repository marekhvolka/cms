<?php

use backend\models\SnippetVar;
use backend\models\VarType;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model backend\models\Snippet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="snippet-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    
    <h3 class="page-header">Všeobecné <small>nastavenia</small></h3>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'snippet_type')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX,
        'pluginOptions'=>[
            'onText'=>'Dynamický',
            'offText'=>'Statický'
        ]
    ]) ?>

    <div class="form-group">
        <div class="panel panel-default">
            <div class="panel-heading"><h4>Alternatívy</h4></div>
            <div class="panel-body">
                <ul class="container-items-codes">
                <?php foreach ($snippetCodes as $snippetCode): ?>
                <li>
                    <?= $this->render('_code', ['snippetCode' => $snippetCode]) ;?>
                </li>
                <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>
    
    <?= $form->field($model, 'description')->textarea(['rows' => '4']) ?>
    
    <?= $this->render('_blocks-and-sections', ['model' => $model]); ?>
    
    <div class="form-group">
        <div class="panel panel-default">
            <div class="panel-heading"><h4>Premenné</h4></div>
            <div class="panel-body">
                <?php
                Select2::widget([
                   'name' => "test",
                ]);
                ?>
                <?php
                $snippetVars = $model->snippetVariables;
                $snippetVars = (empty($snippetVars)) ? [new SnippetVar()] : $snippetVars;
                ?>
                <div><!-- widgetContainer -->
                    <ul style="list-style: none;" class="container-items-vars">
                        <?php foreach ($snippetVars as $y => $snippetVar): ?>
                        <?php if(!$snippetVar->parent && $snippetVar->id): ?>
                        <?= $this->render('_variable', ['snippetVar' => $snippetVar]); ?>
                        <?php endif;?>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="col-sm-offset-2">
                    <button type="button" class="add-item-var btn btn-success">
                        Pridať premennú
                    </button>
                </div>
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
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
 
<?php
$urlForAppendVar = Url::to(['/snippet/append-var']);
$urlForAppendCode = Url::to(['/snippet/append-code']);
$listIdJs = VarType::find()->where(['identifier' => 'list'])->one()->id;

$js = <<<JS

var snippetVarParams = {
    variableHtml: '',
    codeHtml: '',
    listId: $listIdJs,
    appendVarUrl: '$urlForAppendVar',
    appendCodeUrl: '$urlForAppendCode',
}
        
JS;

$this->registerJs($js, View::POS_BEGIN);
$this->registerJsFile('@web/js/snippets.js', [
    'depends' => [\yii\web\JqueryAsset::className()]
]);
?>

