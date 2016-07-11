<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 29.06.16
 * Time: 14:43
 */

use backend\components\MultimediaWidget\MultimediaWidgetAsset;

/* @var $categories \backend\models\MultimediaCategory[] */

MultimediaWidgetAsset::register($this);
?>

<div class="modal fade" id="multimediaWidget" tabindex="-1" role="dialog" aria-labelledby="multimediaModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Zavrieť">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="multimediaModalLabel">Vybrať súbor z multimédii</h4>
            </div>
            <div class="modal-body">
                <?= $this->render('view', ['categories' => $categories, 'modal' => true]) ?>
            </div>
        </div>
    </div>
</div>
