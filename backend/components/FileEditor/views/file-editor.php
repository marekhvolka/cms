<?php
use backend\components\FileEditor\FileEditorAsset;
use backend\components\FileEditor\models\CreateDirectoryForm;
use backend\components\FileEditor\models\EditFileForm;
use conquer\codemirror\CodemirrorAsset;
use conquer\codemirror\CodemirrorWidget;
use kartik\select2\Select2;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */
/* @var $editFileForm EditFileForm */
/* @var $uploadFileForm EditFileForm */
/* @var $createDirectoryForm CreateDirectoryForm */
/* @var $directory string */
/* @var $fileTree array */
/* @var $directoryTree array */
/* @var $isImageLoaded boolean */

FileEditorAsset::register($this);

function build_one_level($data, $from_dir = '')
{
    ?>
    <ul class="jqueryFileTree">
        <?php foreach ($data as $index => $item) {
            if (is_array($item)) {
                $path = $from_dir . '/' . $index;
                // directory
                ?>
                <li class="directory expanded">
                    <?= $index ?> <a href="<?= Url::current(['file' => $path,
                                                                          'fileAction' => 'delete'])
                    ?>" class="delete">x</a> <a href="#"
                                                class="add-file"
                                                data-name='<?= $path ?>'
                                                data-toggle="modal"
                                                data-target="#uploadFileModal">+</a>
                    <?php build_one_level($item, $from_dir . '/' . $index) ?>
                </li>
                <?php
            } else {
                // file
                $extension = pathinfo($item, PATHINFO_EXTENSION);
                $path = $from_dir . '/' . $item;
                ?>
                <li class="file ext_<?= $extension ?>">
                    <a data-name='<?= $path ?>' href="<?= Url::current(['file' => $path]) ?>"
                       class="file-link"><?=
                        $item ?></a> <a href="<?= Url::current(['file' => $path, 'fileAction' => 'delete'])
                    ?>" class="delete">x</a>
                </li>
                <?php
            }
        }
        ?>
    </ul>
    <?php
}

?>

<?php $this->beginBlock('button'); ?>
<?= Html::a('Nahrať súbor', "#", ['class'       => 'btn btn-success pull-right', 'data-name' => '/',
                                  'data-toggle' => "modal", 'data-target' => '#uploadFileModal']) ?>

<?= Html::a('Vytvoriť priečinok', "#", ['class'       => 'btn btn-success pull-right', 'data-name' => '/',
                                        'data-toggle' => "modal", 'data-target' => '#createDirectoryModal']) ?>
<?php $this->endBlock(); ?>

<div class="file-editor">
    <div class="col-xs-12 col-sm-3">
        <div class="row list">


            <?php build_one_level($fileTree) ?>
        </div>
    </div>
    <div class="col-xs-12 col-sm-9">
        <div class="row">
            <h3 class="new-file">Nový súbor</h3>
            <?php if ($editFileForm->fileName == null) { ?><h3 class="select-a-file">Vyberte súbor alebo pridajte
                nový</h3><?php } ?>

            <div class="file-editing" <?php if ($isImageLoaded) : ?>style="display: none"<?php endif; ?>>
                <?php $form = ActiveForm::begin() ?>
                <?= CodemirrorWidget::widget([
                        'name'     => 'EditFileForm[text]',
                        'value'    => $editFileForm->text,
                        'assets'   => [
                            CodemirrorAsset::MODE_CLIKE,
                            CodemirrorAsset::KEYMAP_EMACS,
                            CodemirrorAsset::ADDON_EDIT_MATCHBRACKETS,
                            CodemirrorAsset::ADDON_COMMENT,
                            CodemirrorAsset::ADDON_DIALOG,
                            CodemirrorAsset::ADDON_SEARCHCURSOR,
                            CodemirrorAsset::ADDON_SEARCH,
                        ],
                        'settings' => [
                            'mode'        => 'application/x-httpd-php',
                            'readOnly'    => true
                        ],
                    ]
                ) ?>
                <?= $form->field($editFileForm, 'fileName')->hiddenInput()->label(false) ?>
                <?= Html::submitButton('Uložiť', [
                    'class' => 'btn btn-success',
                    'id'    => 'submit-btn'
                ]) ?>
                <?php $form->end() ?>
            </div>
            <div class="image">
                <img src="<?php if($isImageLoaded) { echo Url::current(['file' => $editFileForm->fileName]); }?>">
            </div>
        </div>
    </div>
</div>

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
                <?= $form->field($uploadFileForm, 'file')->fileInput() ?>
                <?= $form->field($uploadFileForm, 'directory')->widget(Select2::className(), [
                    'data' => $directoryTree,
                    'maintainOrder' => false,
                    'hideSearch' => true
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

<div class="modal fade" id="createDirectoryModal" tabindex="-1" role="dialog" aria-labelledby="createDirectoryModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php $form = ActiveForm::begin() ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Zavrieť">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="createDirectoryModalLabel">Vytvoriť priečinok</h4>
            </div>
            <div class="modal-body">
                <?= $form->field($createDirectoryForm, 'name')->textInput() ?>
                <?= $form->field($createDirectoryForm, 'directory')->widget(Select2::className(), [
                    'data'          => $directoryTree,
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