<?php

use backend\components\PathHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var $data array */
/** @var $this View */
/** @var string $nameOfFunction */

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
                <b>Hľadať:</b> <input type="text" placeholder="Hľadať" class="search">
                <?php
                foreach ($data as $item) {
                    echo "<h3>" . $item['category']->name . " <small>" . $item['subcategory'] . "</small></h3>";
                    ?>
                    <table class="table">
                        <?php foreach ($item['items'] as $file) { ?>
                            <tr>
                                <td>
                                    <?php $url = Url::to([
                                            '/multimedia/file/',
                                            'subcategory' => $file->subcategory,
                                            'categoryName' => $file->categoryName,
                                            'name' => $file->name]
                                    ) ?>
                                    <a href="<?= $url ?>" class="select-link">
                                        <?= $file->name ?>
                                    </a>
                                    <?php if (PathHelper::isImageFile($file->name)) { ?>
                                        <img src="<?= $url ?>" class="thumbnail">
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                    <?php
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close-modal">Zavrieť</button>
                <?= Html::submitButton('Vybrať', [
                    'class' => 'btn btn-primary',
                    'id' => 'submit-btn'
                ]) ?>
            </div>
            <?php $form->end() ?>
        </div>
    </div>
</div>
<style>
    #selectFileFromMultimedia .thumbnail {
        display: none;
        position: absolute;
        max-width: 300px;
        max-height: 300px;
    }

    #selectFileFromMultimedia a:hover + .thumbnail {
        display: block;
    }
</style>
<script type="text/javascript">
    $(function () {
        $(".select-link").click(function (e) {
            e.preventDefault();

            <?= $nameOfFunction ?>($(this).attr("href"));

            $("#selectFileFromMultimedia").modal("hide");
        });

        var modal = $("#selectFileFromMultimedia");
        modal.find(".close-modal").click(function () {
            modal.modal("hide");
        });

        modal.find(".search").on("input", function () {
            var val = $(this).val();
            modal.find(".modal-body td.hidden").removeClass("hidden");
            modal.find(".modal-body td").each(function () {
                if ($(this).text().toLowerCase().indexOf(val.toLowerCase().trim()) == -1) {
                    $(this).addClass("hidden");
                }
            });
        });
    });
</script>
