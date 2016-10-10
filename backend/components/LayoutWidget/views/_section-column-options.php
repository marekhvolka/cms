<?php
use yii\bootstrap\Html;

/* @var $prefix string */

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
                <div class="form-group">
                    <label class="control-label">
                        <?= $model->getAttributeLabel('css_id') ?>
                    </label>
                    <?= Html::input('text', $prefix . '[css_id]', $model->css_id, [
                        'class' => 'form-control'
                    ]) ?>
                </div>
                <div class="form-group">
                    <label class="control-label">
                        <?= $model->getAttributeLabel('css_class') ?>
                    </label>
                    <?= Html::input('text', $prefix . '[css_class]', $model->css_class, [
                        'class' => 'form-control'
                    ]) ?>
                </div>
                <div class="form-group">
                    <label class="control-label">
                        <?= $model->getAttributeLabel('css_style') ?>
                    </label>
                    <?= Html::textarea($prefix . '[css_style]', $model->css_style, [
                        'class' => 'form-control'
                    ]) ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
            </div>
        </div>
    </div>
</div>