<?php
use common\widgets\FileEditor\models\EditFileForm;
use yii\bootstrap\Html;

/* @var $this \yii\web\View */
/* @var $model EditFileForm */
/* @var $directory string */
/* @var $fileTree array */

\common\widgets\FileEditor\FileEditorAsset::register($this);

$this->registerJs(<<<JS
$(function(){
  var file_editor = $('.file-editor'),
    textarea = file_editor.find('textarea'),
    file_name_input = file_editor.find('#editfileform-filename'),
    opened_file = null;
  
  function openFile(filePath, url) {
    opened_file = filePath;
    
    textarea.attr('disabled', true);
    file_name_input.val(filePath);
        
    $.get(url, function(data) {
        textarea.val(data);
        textarea.removeAttr('disabled');
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
            <?= $form->field($model, 'text')->textarea()->label(false) ?>
            <?= $form->field($model, 'fileName')->hiddenInput()->label(false) ?>
            <?= Html::submitButton('Uložiť', [
                'class' => 'btn btn-success',
                'id'    => 'submit-btn'
            ]) ?>
            <?php $form->end() ?>
        </div>
    </div>
</div>