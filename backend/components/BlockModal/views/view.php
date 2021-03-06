<?php

use backend\models\Block;
use backend\models\Portal;

/* @var $model Block */
/* @var $layoutOwner \backend\models\LayoutOwner */
/* @var $portal Portal */
/* @var $prefix string */

?>
<div class="modal block-modal" id="modal" role="dialog">
    <div class="data-div-block-modal hidden" data-layout-owner-id="<?= $layoutOwner ? $layoutOwner->id : '' ?>"
         data-layout-owner-type="<?= $layoutOwner ? $layoutOwner->getType() : '' ?>"
         data-portal-id="<?= $portal ? $portal->id : '' ?>"></div>
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
                            'layoutOwner' => $layoutOwner,
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




