<?php

use backend\models\Portal;
use backend\models\VarType;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Snippet */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile(Url::to(['js/anchors.js']), ['depends' => ['yii\web\JqueryAsset']]);
?>

<div class="anchors closed">
    <h3 class="toggle"><a href="#">Kotvy</a></h3>
    <div class="opened items">
        <input type="text" placeholder="Hľadať">

        <h4>Alternatívy</h4>
        <?php foreach ($model->snippetCodes as $indexCode => $snippetCode): ?>

            <a href="#code<?= $snippetCode->id ?>"><?= $snippetCode->name ?></a>

        <?php endforeach; ?>
        <h4>Premenné</h4>
        <?php foreach ($model->snippetVariables as $indexCode => $variable): ?>

            <a href="#variable<?= $variable->id ?>"><?= $variable->identifier ?></a>

        <?php endforeach; ?>
    </div>
</div>

<div class="snippet-form">

    <?php $form = ActiveForm::begin([
        'id' => 'dynamic-form',
        'enableAjaxValidation' => true,
    ]); ?>

    <ul class="nav nav-tabs" id="myTab">
        <li role="presentation" class="tab-label active">
            <a href="#tab_basic_settings" data-toggle="tab">Základné nastavenia</a>
        </li>
        <li role="presentation" class="tab-label">
            <a href="#tab_codes_settings" data-toggle="tab">Kódy</a>
        </li>
        <li role="presentation" class="tab-label">
            <a href="#tab_variables_settings" data-toggle="tab">Premenné</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade in active" id="tab_basic_settings">

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <div class="form-group">
                <label class="control-label" for="snippetcode-portal">
                    Zobrazovať pre portály
                </label>

                <?= Select2::widget([
                    'name' => 'portals',
                    'value' => array_map(function ($item) {
                        return $item->id;
                    }, $model->portals),
                    'data' => ArrayHelper::map(Portal::find()->all(), 'id', 'name'),
                    'options' => [
                        'placeholder' => 'Priradiť portály',
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                    ],
                ]) ?>
            </div>
            <?= $form->field($model, 'description')->textarea(['rows' => '4']) ?>
        </div>

        <div class="tab-pane" id="tab_codes_settings">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4>
                        Alternatívy
                        <a class="btn btn-success btn-xs btn-add-snippet-code pull-right" data-prefix="">
                            <i class="fa fa-plus"></i>
                        </a>
                    </h4>
                </div>
                <div class="panel-body snippet-codes fixed-panel">
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

        <div class="tab-pane" id="tab_variables_settings">
            <div class="panel panel-success">
                <div class="panel-heading form-inline">
                    <h4>
                        Premenné
                        <a class="btn btn-success btn-xs btn-add-snippet-var pull-right" data-prefix="SnippetVar">
                            <i class="fa fa-plus"></i>
                        </a>
                    </h4>
                </div>
                <div class="panel-body snippet-vars-container fixed-panel">
                    <?php foreach ($model->snippetFirstLevelVars as $indexVar => $snippetVar): ?>
                        <?= $this->render('_variable', [
                            'model' => $snippetVar,
                            'prefix' => "SnippetVar[$indexVar]"
                        ]); ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

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

                <?= Html::a('Hard reset', Url::to(['hard-reset', 'id' => $model->id]), [
                    'class' => 'btn btn-danger',
                    'target' => '_blank'
                ]) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$controllerUrl = Url::to(['/snippet']);
$listIdJs = VarType::find()->where(['identifier' => 'list'])->one()->id;
$snippetCodeUsageUrl = Url::to(['/snippet/code-usage', 'id' => 'code-id']);

$js = <<<JS

var listId = $listIdJs;
var controllerUrl = '$controllerUrl';
var snippetCodeUsageUrl = '$snippetCodeUsageUrl';

JS;

$this->registerJs($js, View::POS_BEGIN);
$this->registerJsFile('@web/js/snippets.js', [
    'depends' => [\yii\web\JqueryAsset::className()]
]);
?>

<div class="modal fade" id="alternativeUsedIn" tabindex="-1" role="dialog" aria-labelledby="alternativeUsedInLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Zavrieť">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="alternativeUsedInLabel">Použitie alternatívy</h4>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>