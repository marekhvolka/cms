<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\BaseHtml;
use yii\bootstrap\Modal;
use yii\bootstrap\Nav;
use kartik\sortable\Sortable;

use backend\models\Section;
use backend\models\Row;
use backend\models\Column;
use backend\models\PageBlock;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $sections \backend\models\Section */
?>

<?php
//Sortable::widget();
?>

<div class="section-form">

    <?php /*
    Modal::begin([
        'header' => '<h4 class="modal-title">Nastavenia sekcie</h4>',
        'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
                <button type="button" class="btn btn-primary btn-save-options" data-dismiss="modal">Uložiť</button>',
        'size' => 'modal-lg',
        'id' => 'modal-options',
    ]);

    echo $this->render('_options');

    Modal::end(); */
    ?>
    
    <?php /*
    Modal::begin([
        'header' => '<h4 class="modal-title">Pridať text</h4>',
        'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
                <button type="button" class="btn btn-primary btn-save-options" data-dismiss="modal">Uložiť</button>',
        // 'toggleButton' => ['label' => 'click me2'],
        'size' => 'modal-lg',
        'id' => 'modal-text',
    ]);
    
    echo '<textarea class="text-textarea"></textarea>';

    Modal::end(); */
    ?>

    <ul class="sections">
        <?php foreach ($sections as $section) : ?>
            <?= $this->render('_section', ['section' => $section]); ?>
        <?php endforeach; ?>
    </ul>
    <div class="col-sm-10 col-sm-offset-2">
        <button type="button" class="btn btn-success btn-sm btn-add-section">
            <span class="glyphicon glyphicon-plus"></span> Pridať sekciu
        </button>
    </div>
</div>

<div class="new-items">
    <?= $this->render('_section', ['section' => new Section()]); ?>
    <?= $this->render('_row', ['row' => new Row()]); ?>
    <?= $this->render('_column', ['column' => new Column()]); ?>
    <?= $this->render('_page-block', ['pageBlock' => new PageBlock()]); ?>
</div>

<?php
$js = <<<JS

//$('#modal-1').modal({"show":false});
        
//$('.sections').sortable({});
//$('.section-rows').sortable({});
        
JS;
//$this->registerJs($js);

//$this->registerJsFile('@web/js/layout.js');
?>
