<?php

use backend\models\SnippetVarDefaultValue;
use backend\models\VarType;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;

/* @var $this yii\web\View */
/* @var $model backend\models\SnippetVar */
/* @var $prefix string */

?>

<div class="item panel panel-default snippet-var"><!-- widgetBody -->

    <div class="panel-heading form-inline">
        <label class="control-label" for="snippetvar-identifier">
            <?= $model->getAttributeLabel('identifier'); ?>
        </label>
        <?= BaseHtml::activeTextInput($model, "identifier", [
            'maxlength' => true,
            'class'     => 'form-control',
            'name'      => $prefix . "[identifier]",
        ]);
        ?>

        <button type="button" class="btn-remove-snippet-var btn btn-danger btn-xs pull-right"
                data-var-id="<?= $model->id; ?>">
            <i class="glyphicon glyphicon-minus"></i>
        </button>
    </div>
    <div class="panel-body var-body">

        <div class="row">
            <div class="col-sm-12">

            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <label class="control-label" for="snippetvar-type_id">
                    Typ premennej
                </label>
                <?php
                $allVars = VarType::find()->where(['show_snippet' => 1])->all();
                $data = ArrayHelper::map($allVars, 'id', 'name');

                echo BaseHtml::activeDropDownList($model, 'type_id', $data, [
                    'class'  => 'form-control select-var-type',
                    'prompt' => 'Vyber typ premennej',
                    'name'   => $prefix . "[type_id]",
                    'data-prefix' => $prefix
                ]);
                ?>
            </div>
        </div>


        <?php
        $defaultValue = $model->getDefaultValues()->where("product_type_id IS NULL")->one();
        if (!$defaultValue) {
            $defaultValue = new SnippetVarDefaultValue();
        }

        ?>
        <ul class="snippet-var-default-values">
            <li>
                <?php
                echo $this->render("_variable-default-val", [
                    'defaultValue'   => $defaultValue,
                    'withoutProduct' => true
                ]);
                ?>
            </li>
            <?php
            foreach ($model->getDefaultValues()->where("product_type_id IS NOT NULL")->all() as $defaultValue) {
                echo '<li>';
                echo $this->render("_variable-default-val", [
                    'defaultValue' => $defaultValue
                ]);
                echo '</li>';
            } ?>
        </ul>

        <?= BaseHtml::hiddenInput($prefix . "[parent_id]",
            isset($model->parent_id) ? $model->parent_id : ''); ?>

        <?= BaseHtml::hiddenInput($prefix . "[id]", $model->id, ['class' => 'variable-id']); ?>

        <?= BaseHtml::hiddenInput($prefix . "[existing]", $model->isNewRecord ? 'false' : 'true'); ?>

        <div class="row">
            <div class="col-sm-12">
                <label class="control-label" for="snippetvar-default_value">
                    <?= $model->getAttributeLabel('description'); ?>
                </label>
                <?= BaseHtml::activeTextarea($model, "description", [
                    'rows'  => '4',
                    'class' => 'form-control',
                    'name'  => $prefix . "[description]",
                ]); ?>
            </div>
        </div>

        <?php if (isset($model->type) && $model->type->identifier == 'list'): ?>
            <?= $this->render('_child-var-box', [
                'model' => $model,
                'prefix' => $prefix
            ]); ?>
        <?php endif; ?>

    </div>
</div>
