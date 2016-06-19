<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $sections \backend\models\Section */
?>

<div class="layouts">
    <?php
    $idHash = Yii::$app->security->generateRandomString();  // ID as hash for using more layoutWidget in one view.
    ?>
    <ul class="children-list" id="<?= $idHash ?>">
        <?php foreach ($sections as $section) : ?>
            <li>
                <?= $this->render('_section', ['section' => $section]); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="col-sm-10 col-sm-offset-2">
        <button type="button" class="btn btn-success btn-sm btn-add-section" data-sections-id="<?= $idHash ?>">
            <span class="glyphicon glyphicon-plus"></span> Pridať sekciu
        </button>
    </div>
</div> 

<?php
$portalIdJs = $portalId ? : 'null';
$pageIdJs = $pageId ? : 'null';

$js = <<<JS

var controllerUrl = '$controllerUrl';
var layoutType = '$type';
var portalId = $portalIdJs;
var pageId = $pageIdJs;
var formId = '$formId';
        
JS;

$this->registerJs($js, \yii\web\View::POS_BEGIN);
?>
