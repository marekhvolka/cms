<?php

use backend\models\Block;

/* @var $model Block */
/* @var $product \backend\models\Product */
/* @var $prefix string */

?>
<style>
    .modal-dialog {
        width: 1000px !important;
    }
</style>
<div class="modal" id="modal" role="dialog">
    <div class="modal-dialog modal-xlg">
        <div class="modal-content">
            <div class="modal-main-content">
                <?php
                switch ($model->type) {
                    case 'product_snippet' :

                    case 'portal_snippet' :

                    case 'snippet' :

                        echo $this->render('_snippet', [
                            'model' => $model,
                            'prefix' => $prefix,
                            'product' => $product
                        ]);

                        break;
                    case 'text' :

                        echo $this->render('_text', [
                            'model' => $model,
                            'prefix' => $prefix
                        ]);

                        break;
                    case 'html' :

                        echo $this->render('_html', [
                            'model' => $model,
                            'prefix' => $prefix
                        ]);

                        break;
                }
                ?>
            </div>

            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-modal-close" data-dismiss="modal">Zavrieť</button>
                <button type="button" class="btn btn-primary btn-modal-save">Uložiť</button>
                <button type="button" class="btn btn-info btn-modal-save-and-continue">Uložiť a pokračovať</button>
            </div>
        </div>
    </div>
</div>




