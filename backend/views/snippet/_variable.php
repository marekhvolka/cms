<?php

use backend\models\SnippetVarDefaultValue;
use backend\models\VarType;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SnippetVar */
/* @var $prefix string */

?>

<div class="item panel panel-default snippet-var"><!-- widgetBody -->
    <a class="anchor" id="variable<?= $model->id ?>" name="variable<?= $model->id ?>"></a>
    <div class="panel-heading form-inline">
        <a class="collapse-btn" href="#panelVar<?= $prefix ?>">
            <span>
                <i class="fa fa-angle-down"></i>
            </span>
        </a>

        <?= Html::hiddenInput($prefix . "[parent_id]", $model->parent_id); ?>
        <?= Html::hiddenInput($prefix . "[removed]", $model->removed, ['class' => 'removed']); ?>

        <label class="control-label" for="snippetvar-identifier">
            <?= $model->getAttributeLabel('identifier'); ?>
        </label>
        <?= Html::activeTextInput($model, "identifier", [
            'maxlength' => true,
            'class' => 'form-control',
            'name' => $prefix . "[identifier]",
        ]);
        ?>

        <button type="button" class="btn-remove-snippet-var btn btn-danger btn-xs pull-right">
            <i class="glyphicon glyphicon-minus"></i>
        </button>
    </div>
    <div class="panel-body panel-collapse collapse in var-body" id="panelVar<?= $prefix ?>">
        <div class="row">
            <div class="col-sm-12">
                <label class="control-label" for="snippetvar-type_id">
                    Typ premennej
                </label>
                <?php
                $allTypes = VarType::find()->where(['show_snippet' => 1])->all();
                $data = ArrayHelper::map($allTypes, 'id', 'name');

                echo Html::activeDropDownList($model, 'type_id', $data, [
                    'class' => 'form-control select-var-type',
                    'prompt' => 'Vyber typ premennej',
                    'name' => $prefix . "[type_id]",
                    'data-prefix' => $prefix
                ]);
                ?>
            </div>
        </div>

        <?php if ($model->supportDefaultValues()) : ?>
            <div class="row">
                <div class="col-md-12">
                    <label class="control-label">
                        Defaultne hodnoty
                    </label>

                    <div class="snippet-var-default-values">
                        <?php foreach ($model->defaultValues as $indexDefaultValue => $defaultValue) : ?>
                            <?= $this->render("_variable-default-val", [
                                'defaultValue' => $defaultValue,
                                'parentPrefix' => $prefix,
                                'prefix' => $prefix . "[SnippetVarDefaultValue][$indexDefaultValue]",
                                'forProductType' => false
                            ])
                            ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($model->type && $model->type->identifier == 'dropdown') : ?>
            <div class="row">
                <div class="col-md-12 dropdown-container">
                    <h4 class="control-label">
                        Dropdown hodnoty
                        <button type="button" class="btn btn-success btn-xs btn-add-snippet-var-dropdown pull-right" data-toggle="dropdown"
                                title="Pridať dropdown moznost" data-parent-prefix="<?= $prefix ?>" onclick="">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                    </h4>

                    <div class="snippet-var-dropdown-values">
                        <?php foreach ($model->dropdownValues as $indexDropdownValue => $dropdownValue) : ?>
                            <?= $this->render("_variable-dropdown-val", [
                                'model' => $dropdownValue,
                                'parentPrefix' => $prefix,
                                'prefix' => $prefix . "[SnippetVarDropdownValue][$indexDropdownValue]",
                            ])
                            ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-12">
                <label class="control-label" for="snippetvar-default_value">
                    <?= $model->getAttributeLabel('description'); ?>
                </label>
                <?= Html::activeTextarea($model, "description", [
                    'rows' => '4',
                    'class' => 'form-control',
                    'name' => $prefix . "[description]",
                ]); ?>
            </div>
        </div>
        <div class="list-box-container">
            <?php if (isset($model->type) && $model->type->identifier == 'list'): ?>
                <?= $this->render('_child-var-box', [
                    'model' => $model,
                    'prefix' => $prefix
                ]); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
