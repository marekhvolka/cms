<?php

use backend\models\Block;
use backend\models\Portal;

/* @var $model Block */
/* @var $page \backend\models\Page */
/* @var $portal Portal */
/* @var $prefix string */

?>
<div class="modal block-modal" id="modal" role="dialog">
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
                            'page' => $page,
                            'portal' => $portal
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




