<?php

use backend\components\PathHelper;
use backend\models\MultimediaItem;
use backend\models\Portal;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\MultimediaCategory */
/* @var $activeSubcategory string */
/* @var $uploadFile MultimediaItem */
/* @var $dataProvider \yii\data\ArrayDataProvider */

$this->title = 'Upraviť súbory kategórie' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Multimédia', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upraviť';

\backend\assets\FancyBoxAsset::register($this);

$this->registerJsFile('@web/js/multimedia.js', ['depends' => [yii\web\JqueryAsset::className()]]);
$subcategories = $model->getSubcategories();

?>
<div class="multimedia-files-update">

    <table>
        <tr>
            <td>
                Zobraziť
            </td>
            <td class="select-subcategory">
                <?php
                echo Select2::widget([
                    'data'  => [null => 'Všetky súbory'] + $subcategories,
                    'name'  => 'subcategory',
                    'value' => $activeSubcategory
                ]);
                ?>
            </td>
        </tr>
    </table>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'  => 'Meno',
                'format' => 'raw',
                'value'  => function ($dataProvider) {
                    return Html::a(
                        $dataProvider->name,
                        Url::to([
                            '/multimedia/file/',
                            'subcategory'  => $dataProvider->subcategory,
                            'categoryName' => $dataProvider->categoryName,
                            'name'         => $dataProvider->name], 'http'
                        ), ['class' => PathHelper::isImageFile($dataProvider->name) ? 'image-multimedia' : '']
                    );
                },
            ],

            [
                'label'  => 'Podkategória',
                'format' => 'raw',
                'value'  => function ($dataProvider) {
                    $portal = Portal::findOne($dataProvider->subcategory);

                    return $dataProvider->subcategory == "global" ? "Spoločné pre všetky portály" : ($portal == null ? null : $portal->name);
                },
            ],

            [
                'class'      => 'yii\grid\ActionColumn',
                'template'   => '{delete}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    $url = Url::current(['file-action' => $action, 'item-name' => $model->name, 'item-subcategory' => $model->subcategory]);

                    return $url;
                }
            ],
        ],
    ]); ?>
</div>

<?php $this->beginBlock('button'); ?>
<?= Html::a('Nahrať súbor', "#", ['class'       => 'btn btn-success pull-right', 'data-name' => '/',
                                  'data-toggle' => "modal", 'data-target' => '#uploadFileModal']) ?>
<?php $this->endBlock(); ?>

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
                <?= $form->field($uploadFile, 'subcategory')->widget(Select2::className(), [
                    'data'          => $subcategories,
                    'maintainOrder' => false,
                    'hideSearch'    => true
                ]) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
                <?= Html::submitButton('Nahrať', [
                    'class' => 'btn btn-primary',
                    'id'    => 'submit-btn'
                ]) ?>
            </div>
            <?php $form->end() ?>
        </div>
    </div>
</div>