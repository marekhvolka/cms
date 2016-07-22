<?php
use yii\bootstrap\Html;
?>

<div class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Zavrieť">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="uploadFileModalLabel">Upraviť nastavenia sekcie</h4>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td><?= $model->getAttributeLabel('css_id') ?></td>
                        <td><?= Html::input('text', $prefix . '[css_id]', $model->css_id) ?></td>
                    </tr>
                    <tr>
                        <td><?= $model->getAttributeLabel('css_style') ?></td>
                        <td><?= Html::input('text', $prefix . '[css_style]', $model->css_style) ?></td>
                    </tr>
                    <tr>
                        <td><?= $model->getAttributeLabel('css_class') ?></td>
                        <td><?= Html::input('text', $prefix . '[css_class]', $model->css_class) ?></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
            </div>
        </div>
    </div>
</div>