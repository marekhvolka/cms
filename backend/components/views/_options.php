<?php

use yii\helpers\BaseHtml;

/* @var $this yii\web\View */
/* @var $options object */
?>

<div id="options">
    <div class="form-group">
        <label>ID</label>
<?= BaseHtml::textInput('section-id', isset($options) ? $options->id : '', ['placeholder' => 'ID', 'class' => 'form-control']) ?>
    </div>
    <div class="form-group">
        <label>Class</label>
<?= BaseHtml::textInput('section-class', isset($options) ? $options->class : '', ['placeholder' => 'Class', 'class' => 'form-control']) ?>
    </div>
    <div class="form-group">
        <label>Style</label>
<?= BaseHtml::textarea('section-style', isset($options) ? $options->style : '', ['placeholder' => 'Style', 'class' => 'form-control', 'rows' => 6]) ?>
    </div>    
</div>
