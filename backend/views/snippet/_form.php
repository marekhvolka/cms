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
                                        <?= $form->field($modelSnippetCode, 'portal')->textInput() ?>
                                        <!--<label class="control-label" for="productvar-product_type"><?= $modelSnippetCode->getAttributeLabel('portal');?></label>-->
                                        <?php
//                                        $portals = Portal::find()->all();
//                                        $portals_data = ArrayHelper::map($portals, 'id', 'name');
//                                        
//                                        $selected_vars = $modelSnippetCode->portal ? 
//                                                Portal::find()->where('id in (' . $modelSnippetCode->portal . ')')->all() : [];
//                                        $selected_vars_data = ArrayHelper::map($selected_vars, 'id', 'id');
//                                        
//                                        $id_suffix = $modelSnippetCode ? $modelSnippetCode->id : '';
//                                        
//                                        echo Select2::widget([
//                                            'name' => 'snippet_code_portals',
//                                            'value' => $selected_vars_data,
//                                            'data' => $portals_data,
//                                            'id' => 'snippet_code_portals-' . $id_suffix,
//                                            'options' => [
//                                                'placeholder' => 'Select or type cover url ...',
//                                                'multiple' => true,
//                                            ],
//                                            'pluginOptions' => [
//                                                'tags' => true,
//                                            ],
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
    
    <?php $snippetVars = $model->snippetVars; ?>
    
    
    
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
 
<?php

$js = <<<JS

$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    var myTextarea = item.getElementsByClassName('html-editor')[0];
    var editor = CodeMirror.fromTextArea(myTextarea, {
        lineNumbers: true
    });    
});
        
JS;
$this->registerJs($js);
?>