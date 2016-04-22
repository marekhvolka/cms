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
                <div class="container-items">
                    <?php foreach ($modelsSnippetCode as $i => $modelSnippetCode): ?>
                    <?= $this->render('_code', ['modelSnippetCode' => $modelSnippetCode, 'i' => $i, 'form' => $form]) ;?>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
    
    <?= $form->field($model, 'description')->textarea(['rows' => '4']) ?>
    
    
    <?php // TODO - this could be refactored - maybe moved to snippet ?>
    
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Nastavenia sekcie</div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">id</span>
                                    <input type="text" id="snippet-sekcia_id" value="<?=$model->sekcia_id?>" class="form-control" name="Snippet[sekcia_id]" maxlength="30">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">class</span>
                                    <input type="text" id="snippet-sekcia_class" value="<?=$model->sekcia_class?>" class="form-control" name="Snippet[sekcia_class]" maxlength="30">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">style</span>
                                    <input type="text" id="snippet-sekcia_style" value="<?=$model->sekcia_style?>" class="form-control" name="Snippet[sekcia_style]" maxlength="30">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Nastavenia bloku</div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">id</span>
                                    <input type="text" id="snippet-block_id" value="<?=$model->block_id?>" class="form-control" name="Snippet[block_id]" maxlength="30">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">class</span>
                                    <input type="text" id="snippet-block_class" value="<?=$model->block_class?>" class="form-control" name="Snippet[block_class]" maxlength="30">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">style</span>
                                    <input type="text" id="snippet-block_style" value="<?=$model->block_style?>" class="form-control" name="Snippet[block_style]" maxlength="30">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
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
                
                <button type="button" class="add-item-vars btn btn-success btn-xs">
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
$url = Url::to(['/snippet/append-var']);
$listIdJs = VarType::find()->where(['type' => 'list'])->one()->id;
//$variableCodeJs = $this->render('_variable', ['snippetVar' => new SnippetVar()]);

$js = <<<JS

var snippetVarParams = {
    variableCode: '',
    listId: $listIdJs,
    appendVarUrl: '$url',
}
        
JS;

$this->registerJs($js, View::POS_BEGIN);

?>

