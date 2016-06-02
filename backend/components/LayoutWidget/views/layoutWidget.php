<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $sections \backend\models\Section */
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

    <?php
    $idHash = Yii::$app->security->generateRandomString();  // ID as hash for using more layoutWidget in one view.
    ?>
    <ul class="sections" id="<?= $idHash?>">
        <?php foreach ($sections as $section) : ?>
        <li>
            <?= $this->render('_section', ['section' => $section]); ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <div class="col-sm-10 col-sm-offset-2">
        <button type="button" class="btn btn-success btn-sm btn-add-section" data-sections-id="<?=$idHash?>">
            <span class="glyphicon glyphicon-plus"></span> Pridať sekciu
        </button>
    </div>
</div>

<?php
$js = <<<JS

var controllerUrl = '$controllerUrl';
JS;

$this->registerJs($js, \yii\web\View::POS_BEGIN);
?>
