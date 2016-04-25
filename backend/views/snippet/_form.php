<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\switchinput\SwitchInput;
use conquer\codemirror\CodemirrorWidget;
use conquer\codemirror\CodemirrorAsset;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\Portal;
use backend\models\VarType;
use backend\models\SnippetVar;
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
            <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Alternatívy</h4></div>
            <div class="panel-body">
                <div class="container-items-codes">
                    <?php foreach ($snippetCodes as $i => $snippetCode): ?>
                    <?= $this->render('_code', ['snippetCode' => $snippetCode, 'i' => $i, 'form' => $form]) ;?>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
    
    <?= $form->field($model, 'description')->textarea(['rows' => '4']) ?>
    
    <?= $this->render('_blocks-and-sections', ['model' => $model]); ?>
    
    <div class="form-group">
        <div class="panel panel-default">
            <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Premenné</h4></div>
            <div class="panel-body">
                <?php
                $snippetVars = $model->snippetVars;
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
                
                <button type="button" class="add-item-var btn btn-success btn-xs">
                    <i class="glyphicon glyphicon-plus"></i>Add
                </button>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'id' => 'submit-btn'
            ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
 
<?php
$urlForAppendVar = Url::to(['/snippet/append-var']);
$urlForAppendCode = Url::to(['/snippet/append-code']);
$listIdJs = VarType::find()->where(['type' => 'list'])->one()->id;
//$variableCodeJs = $this->render('_variable', ['snippetVar' => new SnippetVar()]);

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

?>

