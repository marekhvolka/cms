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
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $modelsSnippetCode[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'full_name',
                        'address_line1',
                        'address_line2',
                        'city',
                        'state',
                        'postal_code',
                    ],
                ]); ?>

                <div class="container-items"><!-- widgetContainer -->
                    <?php foreach ($modelsSnippetCode as $i => $modelSnippetCode): ?>
                        <div class="item panel panel-default"><!-- widgetBody -->
                            <button type="button" class="remove-item btn btn-danger btn-xs">
                                <i class="glyphicon glyphicon-minus"></i>
                            </button>
                            
                            <div class="panel-heading"> 
                                <div class="input-group">
                                    <?= $form->field($modelSnippetCode, "[{$i}]name")->textInput(['maxlength' => true]) ?>
                                    <div class="pull-right">
                                        <button type="button" class="add-item btn btn-success btn-xs">
                                            <i class="glyphicon glyphicon-plus"></i>
                                        </button>
                                        
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <?php
                                // necessary for update action.
                                if (! $modelSnippetCode->isNewRecord) {
                                    echo Html::activeHiddenInput($modelSnippetCode, "[{$i}]id");
                                }
                                ?>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <?php
                                            echo $form->field($modelSnippetCode, "[{$i}]code")->widget(
                                                CodemirrorWidget::className(),
                                                [
                                                    'assets' => [
                                                        CodemirrorAsset::MODE_CLIKE,
                                                        CodemirrorAsset::KEYMAP_EMACS,
                                                        CodemirrorAsset::ADDON_EDIT_MATCHBRACKETS,
                                                        CodemirrorAsset::ADDON_COMMENT,
                                                        CodemirrorAsset::ADDON_DIALOG,
                                                        CodemirrorAsset::ADDON_SEARCHCURSOR,
                                                        CodemirrorAsset::ADDON_SEARCH,
                                                    ],
                                                    'settings' => [
                                                        'lineNumbers' => true,
                                                        'mode' => 'text/x-csrc',
                                                    ],
                                                    'options' => [
                                                        'class' => 'html-editor'
                                                    ]
                                                ]
                                            );
                                        ?>
                                    </div>
                                </div><!-- .row -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?= $form->field($modelSnippetCode, "[{$i}]popis")->textarea(['rows' => '4']) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?= $form->field($modelSnippetCode, "[{$i}]portal")->textInput(['maxlength' => true]) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php DynamicFormWidget::end(); ?>
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
                
                
                DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper_vars', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item-vars', // css class
                    'deleteButton' => '.remove-item-vars', // css class
                    'model' => $snippetVars[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'full_name',
                        'address_line1',
                        'address_line2',
                        'city',
                        'state',
                        'postal_code',
                    ],
                ]); ?>
    
                <div class="container-items"><!-- widgetContainer -->
                    <?php foreach ($snippetVars as $y => $snippetVar): ?>
                        <div class="item panel panel-default"><!-- widgetBody -->
                            <button type="button" class="remove-item-vars btn btn-danger btn-xs">
                                <i class="glyphicon glyphicon-minus"></i>
                            </button>
    
                            <div class="panel-heading"> 
                                <div class="input-group">
                                    <div class="pull-right">
                                        <button type="button" class="add-item-vars btn btn-success btn-xs">
                                            <i class="glyphicon glyphicon-plus"></i>
                                        </button>
    
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <?php
                                // necessary for update action.
                                if (! $modelSnippetCode->isNewRecord) {
                                    echo Html::activeHiddenInput($modelSnippetCode, "[{$y}]id");
                                }
                                ?>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <?= $form->field($snippetVar, "[{$y}]identifier")->textInput(['maxlength' => true]) ?>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?= $form->field($snippetVar, "[{$y}]type_id")->textInput() ?>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?= $form->field($snippetVar, "[{$y}]default_value")->textInput() ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <?= $form->field($snippetVar, "[{$y}]description")->textarea(['rows' => '4']) ?>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?php
                                        $allVars = VarType::find()->where(['show_snippet' => 1])->all();
                                        $data = ArrayHelper::map($allVars, 'id', 'type');
                                        
                                     //   echo $form->field($snippetVar, 'type')->dropDownList($data, ['prompt'=>'Select...']);
                                        
//                                        echo Select2::widget([
//                                            'name' => 'type',
//                                            'value' => $snippetVar->type_id,
//                                            'data' => $data,
//                                            'options' => [
//                                                'placeholder' => 'Select type ...',
//                                            ],
//                                            
//                                        ]);
                                        
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
 
<?php

$js = <<<JS

// Add item - new Snippet code and initialize Codemirrod library to according code attribute textarea.
$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    var myTextarea = item.getElementsByClassName('html-editor')[0];
    var editor = CodeMirror.fromTextArea(myTextarea, {
        lineNumbers: true
    }); 
});

//$(".dynamicform_wrapper_vars").on("beforeInsert", function(e, item) {
//    var select = $(item).find('select');
//    select.select2();
//});
        
JS;
$this->registerJs($js);
?>