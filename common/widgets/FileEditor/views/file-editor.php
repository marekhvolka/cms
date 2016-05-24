<?php
use common\widgets\FileEditor\models\EditFileForm;
use conquer\codemirror\CodemirrorAsset;
use conquer\codemirror\CodemirrorWidget;
use yii\bootstrap\Html;

/* @var $this \yii\web\View */
/* @var $model EditFileForm */
/* @var $directory string */
/* @var $fileTree array */

\common\widgets\FileEditor\FileEditorAsset::register($this);

$this->registerJs(<<<JS
$(function(){
  var file_editor = $('.file-editor'),
    code_mirror = $('.CodeMirror')[0].CodeMirror,
    file_name_input = file_editor.find('#editfileform-filename'),
    opened_file = null;
  
  function openFile(filePath, url) {
    opened_file = filePath;
    
    code_mirror.setOption('readOnly', true);
    file_name_input.val(filePath);
        
    $.get(url, function(data) {
        code_mirror.getDoc().setValue(data);
        code_mirror.setOption("mode", 'application/x-httpd-php');
        code_mirror.setOption('readOnly', false);
    });
  }
  
  
  file_editor.find('.file-link').click(function(e) {
    e.preventDefault();
    var _this = $(this);
    openFile(_this.attr('data-name'), _this.attr('href'));
  });
});


JS
);

?>

<?php

function build_one_level($data, $from_dir = '')
{
    ?>
    <ul class="jqueryFileTree">
        <?php foreach ($data as $index => $item) {
            if (is_array($item)) {
                // directory
                ?>
                <li class="directory expanded">
                    <?= $index ?>
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
                        $item ?></a>
                </li>
                <?php
            }
        }
        ?>
    </ul>
    <?php
}

?>
<div class="file-editor">
    <div class="col-xs-12 col-sm-2">
        <div class="row">
            <?php build_one_level($fileTree) ?>
        </div>
    </div>
    <div class="col-xs-12 col-sm-10">
        <div class="row">
            <?php $form = \yii\bootstrap\ActiveForm::begin() ?>
            <?= CodemirrorWidget::widget([
                    'name'     => 'EditFileForm[text]',
                    'value'    => $model->text,
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
                    ],
                ]
            ) ?>
            <?= $form->field($model, 'fileName')->hiddenInput()->label(false) ?>
            <?= Html::submitButton('Uložiť', [
                'class' => 'btn btn-success',
                'id'    => 'submit-btn'
            ]) ?>
            <?php $form->end() ?>
        </div>
    </div>
</div>