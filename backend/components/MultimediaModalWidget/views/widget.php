<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var $data array */
/** @var $this View */
/** @var string $nameOfFunction */
$js = <<<JS
if (window.multimediaWidgetLoaded !== true){
    window.multimediaWidgetLoaded = true;
    
    $(function() {
        $(".select-link").click(function(e) {
            e.preventDefault();
            
            var funcName = $nameOfFunction;
            
            $nameOfFunction($(this).attr("href"));
            
            $("#selectFileFromMultimedia").modal("hide");
        })
    });
}
JS;

$this->registerJs($js, View::POS_END);
?>

<div class="modal fade" id="selectFileFromMultimedia" tabindex="-1" role="dialog"
     aria-labelledby="selectFileFromMultimediaLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php $form = ActiveForm::begin() ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Zavrieť">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="selectFileFromMultimediaLabel">Vybrať súbor</h4>
            </div>
            <div class="modal-body">
                <?php
                foreach ($data as $item) {
                    echo "<h3>" . $item['category']->name . " <small>" . $item['subcategory'] . "</small></h3>";
                    ?>
                    <table class="table">
                        <?php foreach ($item['items'] as $file) { ?>
                            <tr>
                                <td>
                                    <a href="<?= Url::to([
                                            '/multimedia/file/',
                                            'subcategory' => $file->subcategory,
                                            'categoryName' => $file->categoryName,
                                            'name' => $file->name]
                                    ) ?>" class="select-link"><?= $file->name ?></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                    <?php
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
                <?= Html::submitButton('Vybrať', [
                    'class' => 'btn btn-primary',
                    'id' => 'submit-btn'
                ]) ?>
            </div>
            <?php $form->end() ?>
        </div>
    </div>
</div>
