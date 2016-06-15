<?php

use backend\assets\AppAsset;
use backend\components\AjaxLoading\AjaxLoadingWidget;
use backend\models\Block;
use yii\bootstrap\Html;

/* @var $model Block */
/* @var $htmlBody bool */
?>
<style>
    .modal-dialog {
        width: 1000px !important;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="modal-<?= $model->id ?>" tabindex="-1" role="dialog">
    <?php
    switch ($model->type) {
        case 'product_snippet' :

        case 'portal_snippet' :

        case 'snippet' :

            echo $this->render('_snippet', [
                'model' => $model,
                'productType' => $productType
            ]);

            break;
        case 'text' :

            echo $this->render('_text', ['model' => $model]);

            break;
        case 'html' :

            echo $this->render('_html', ['model' => $model]);

            break;
    }
    ?>
</div>




