<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\BaseHtml;
use yii\bootstrap\Modal;
use yii\bootstrap\Nav;
use kartik\sortable\Sortable;

/* @var $this yii\web\View */
/* @var $model backend\models\Section */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
Sortable::widget();
?>

<div class="section-form">

    <?php
    Modal::begin([
        'header' => '<h4 class="modal-title">Nastavenia sekcie</h4>',
        'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
                <button type="button" class="btn btn-primary btn-save-options" data-dismiss="modal">Uložiť</button>',
        // 'toggleButton' => ['label' => 'click me2'],
        'size' => 'modal-lg',
        'id' => 'modal-options',
    ]);

    echo $this->render('_options');

    Modal::end();
    ?>

    <ul class="sections">
    </ul>

    <div class="col-sm-10 col-sm-offset-2">
        <button type="button" class="btn btn-success btn-sm btn-add-section">
            <span class="glyphicon glyphicon-plus"></span> Pridať sekciu
        </button>
    </div>

</div>

<?php
$js = <<<JS

//$('#modal-1').modal({"show":false});
        
$('.sections').sortable({});
$('.section-rows').sortable({});
        
JS;
$this->registerJs($js);

$this->registerJsFile('@web/js/sections.js');
?>



<!--SECTION TO ADD-->
<li class="panel panel-default section cloned-section" 
     data-options="{}" hidden="hidden">
    <div class="btn-group section-buttons">
        <div class="section-button">
            <button class="btn btn-primary options-btn btn-xs" data-toggle="modal" data-target="#modal-options">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </button>
        </div>
        <div class="dropdown dropdown-blocks section-button">
            <button type="button" class="btn btn-success dropdown-toggle add-row-btn btn-xs" 
                    title="Vložiť nový blok" data-toggle="dropdown">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#" class="add-row" data-row-type-width="1">Fullwidth blok</a></li>
                <li><a href="#" class="add-row" data-row-type-width="2">2 stĺpcový blok</a></li>
                <li><a href="#" class="add-row" data-row-type-width="3">3 stĺpcový blok</a></li>
                <li><a href="#" class="add-row" data-row-type-width="4">4 stĺpcový blok</a></li>
                <li><a href="#" class="add-row" data-row-type-width="2/1">2/1 blok</a></li>
                <li><a href="#" class="add-row" data-row-type-width="1/2">1/2 blok</a></li>
            </ul>
        </div>
        <div class="section-button">
            <button type="button" class="btn btn-danger btn-xs btn-remove-section" title="Zmazať" >
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    <div class="panel-heading"><h3 class="panel-title">Sekcia</h3></div>
    <div class="panel-body">
        <div class="col-sm-12">
            <ul class="section-rows"></ul>
        </div>
    </div>
</li>

<!--ROW TO ADD-->
<div class="row cloned-row" hidden="hidden">
    
</div>

<!--COLUMN TO ADD-->
<div class="panel panel-default cloned-column" data-options="{}" hidden="hidden">

    <div class="btn-group section-buttons">
        <div class="section-button">
            <button class="btn btn-primary options-btn btn-xs" data-toggle="modal" data-target="#modal-options">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </button>
        </div>
        <div class="dropdown dropdown-column-content section-button">
            <button type="button" class="btn btn-success dropdown-toggle add-row-btn btn-xs" 
                    title="Vložiť nový blok" data-toggle="dropdown">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#">Text</a></li>
                <li><a href="#">HTML</a></li>
                <li><a href="#">Smart snippet</a></li>
                <li><a href="#">Produktový snippet</a></li>
                <li><a href="#">Portálový snippet</a></li>
            </ul>
        </div>
        <div class="section-button">
            <button type="button" class="btn btn-danger btn-xs btn-remove-row" title="Zmazať" >
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    <div class="panel-heading">1. stĺpec</div>
    <div class="panel-body"></div>

</div>
