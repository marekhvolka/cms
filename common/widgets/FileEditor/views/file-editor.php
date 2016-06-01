<?php
use common\widgets\FileEditor\models\EditFileForm;
use conquer\codemirror\CodemirrorAsset;
use conquer\codemirror\CodemirrorWidget;
use yii\bootstrap\Html;

/* @var $this \yii\web\View */
/* @var $editFileForm EditFileForm */
/* @var $uploadFileForm EditFileForm */
/* @var $directory string */
/* @var $fileTree array */

\common\widgets\FileEditor\FileEditorAsset::register($this);

$this->registerJsFile('web/js/file-editor.js');

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
                    <?= $index ?> <a href="<?= \yii\helpers\Url::current(['file' => $path, 'fileAction'
                                                                                 =>
                        'delete'])
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
                    <a data-name='<?= $path ?>' href="<?= \yii\helpers\Url::current(['file' => $path]) ?>"
                       class="file-link"><?=
                        $item ?></a> <a href="<?= \yii\helpers\Url::current(['file' => $path, 'fileAction' => 'delete'])
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
<?= Html::a('Nahrať súbor', ['create'], ['class'       => 'btn btn-success pull-right add-file',
                                         'data-name'   => '/',
                                         'data-toggle' => 'modal',
                                         'data-target' => '#uploadFileModal']) ?>
<?php $this->endBlock(); ?>

<div class="file-editor">
    <div class="col-xs-12 col-sm-2">
        <div class="row">
            <?php build_one_level($fileTree) ?>
        </div>
    </div>
    <div class="col-xs-12 col-sm-10">
        <div class="row">
            <h3 class="new-file">Nový súbor</h3>
            <?php if ($editFileForm->fileName == null) { ?><h3 class="select-a-file">Vyberte súbor alebo pridajte
                nový</h3><?php } ?>
            <?php $form = \yii\bootstrap\ActiveForm::begin() ?>
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
                        'lineNumbers' => true,
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
    </div>
</div>

<div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-labelledby="uploadFileModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php $form = \yii\widgets\ActiveForm::begin() ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Zavrieť">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="uploadFileModalLabel">Nahrať súbor</h4>
            </div>
            <div class="modal-body">
                <?= $form->field($uploadFileForm, 'file')->fileInput() ?>
                <?= $form->field($uploadFileForm, 'directory')->textInput(['id' => 'uploadFileDirectory']) ?>
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