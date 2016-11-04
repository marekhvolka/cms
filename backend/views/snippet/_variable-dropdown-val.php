<?php
use backend\models\PartnershipType;
use backend\models\ProductType;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\SnippetVarDropdown */
/* @var $indexDropdownValue int */
/* @var $prefix string */
/* @var $parentPrefix string */

?>
<div class="row">
    <div class="col-sm-12">
        <div class="input-group">
            <?= Html::hiddenInput($prefix . "[removed]", $model->removed, ['class' => 'removed']); ?>
            <?= Html::activeTextInput($model, "value", [
                'class' => 'form-control',
                'name' => $prefix . "[value]",
            ]); ?>
            <span class=" input-group-btn remove-btn">
                <a class="btn btn-danger btn-remove-snippet-dropdown-value">
                    <i class="glyphicon glyphicon-remove"></i>
                </a>
            </span>
        </div>
    </div>
</div>