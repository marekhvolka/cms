<?php

use backend\assets\FancyBoxAsset;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $data array */
/* @var $allSubcategories array */
/* @var $allCategories array */
/* @var $uploadFile \backend\models\MultimediaItem */

$this->title = 'Multimédia';
$this->params['breadcrumbs'][] = $this->title;

FancyBoxAsset::register($this);

$this->registerJsFile('@web/js/multimedia.js', ['depends' => [yii\web\JqueryAsset::className()]]);
?>

<?php $this->beginBlock('button'); ?>
<?= Html::a('Nahrať súbor', "#", ['class' => 'btn btn-success pull-right', 'data-name' => '/',
    'data-toggle' => "modal", 'data-target' => '#uploadFileModal']) ?>

<?php $this->endBlock(); ?>

<div class="multimedia-index">
    <?php
    foreach ($data as $item) {
        echo $this->render("_category", [
            'category' => $item['category'],
            'subcategory' => $item['subcategory'],
            'dataProvider' => $item['dataProvider']
        ]);
    }
    ?>
</div>

<!-- UPLOAD A NEW FILE MODAL -->
<div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-labelledby="uploadFileModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php $form = ActiveForm::begin() ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Zavrieť">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="uploadFileModalLabel">Nahrať súbor</h4>
            </div>
            <div class="modal-body">
                <?= $form->field($uploadFile, 'file')->fileInput() ?>
                <?= $form->field($uploadFile, 'categoryName')->widget(Select2::className(), [
                    'data' => ArrayHelper::map($allCategories, 'name', 'name'),
                    'maintainOrder' => false,
                    'hideSearch' => true
                ]) ?><?= $form->field($uploadFile, 'subcategory')->widget(Select2::className(), [
                    'data' => $allSubcategories,
                    'maintainOrder' => false,
                    'hideSearch' => true
                ]) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
                <?= Html::submitButton('Nahrať', [
                    'class' => 'btn btn-primary',
                    'id' => 'submit-btn'
                ]) ?>
            </div>
            <?php $form->end() ?>
        </div>
    </div>
</div>
