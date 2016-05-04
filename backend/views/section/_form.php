<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\BaseHtml;
use yii\bootstrap\Modal;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
/* @var $model backend\models\Section */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="section-form">

    <?php
    Modal::begin([
        'header' => '<h4 class="modal-title" id="myModalLabelBlock">Nastavenia sekcie</h4>',
        // 'toggleButton' => ['label' => 'click me2'],
        'size' => 'modal-lg',
        'id' => 'modal-eee',
    ]);

    echo $this->render('/section/_options');

    Modal::end();
    ?>

    <button type="button" data-toggle="modal" data-target="#modal-eee">click me</button>


    <div class="sections">
        
    </div>

    

    <div class="col-sm-10 col-sm-offset-2">
        <button type="button" class="btn btn-success btn-sm btn-add-section">
            <span class="glyphicon glyphicon-plus"></span> Pridať sekciu
        </button>
    </div>

</div>

<?php
$js = <<<JS

$('#modal-1').modal({"show":false});
        
JS;
$this->registerJs($js);

$this->registerJsFile('@web/js/sections.js');
?>


<!--SECTION TO ADD-->
<div class="panel panel-default section cloned-section" style="position: relative;" hidden="hidden">
    <div class="btn-group section-buttons">
        <div class="section-button">
            <button class="btn btn-primary dropdown-toggle btn-xs" >
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </button>
        </div>
        <div class="dropdown dropdown-blocks section-button">
            <button type="button" class="btn btn-success dropdown-toggle add-row-btn btn-xs" 
                    title="Vložiť nový blok" data-toggle="dropdown">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#" class="add-row" data-row-type-width="12">Fullwidth blok</a></li>
                <li><a href="#" class="add-row" data-row-type-width="6">2 stĺpcový blok</a></li>
                <li><a href="#" class="add-row" data-row-type-width="4">3 stĺpcový blok</a></li>
                <li><a href="#" class="add-row" data-row-type-width="3">4 stĺpcový blok</a></li>
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
        <div class="col-sm-12 section-rows"> 
            
        </div>
    </div>
</div>

<!--ROW TO ADD-->
<div class="row cloned-row" hidden="hidden">
    <div class="layout-wrapper">
        
    </div>
</div>

<!--COLUMN TO ADD-->
<div class="panel panel-default cloned-column" hidden="hidden">

    <div class="btn-group section-buttons">
        <div class="section-button">
            <button class="btn btn-primary dropdown-toggle btn-xs" >
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
            <button type="button" class="btn btn-danger btn-xs btn-remove-column" title="Zmazať" >
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    <div class="panel-heading">1. stĺpec</div>
    <div class="panel-body"></div>

</div>
