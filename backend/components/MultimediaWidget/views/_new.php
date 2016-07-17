<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 29.06.16
 * Time: 14:55
 */

use backend\models\MultimediaCategory;
use backend\models\MultimediaItem;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$model = new MultimediaItem();

/* @var $modal boolean */
/* @var $categories MultimediaCategory[] */

?>
<div class="form-group">
    <label class="col-sm-2 control-label">Umiestnenie</label>
    <div class="col-sm-10">
        <?= Html::activeDropDownList($model, 'path',
            ArrayHelper::map($categories, 'path', 'fullName'), [
                'class' => 'form-control select-path'
            ]) ?>
    </div>
    <div class="clearfix"></div>
</div>
<div class="form-group upload-multimedia-file">
    <label class="col-sm-2 control-label">Súbory</label>
    <div class="col-sm-10">
        <?= FileInput::widget([
            'model' => $model,
            'attribute' => 'files',
            'options' => [
                'multiple' => !$modal
            ]
        ]); ?>
    </div>
    <div class="clearfix"></div>
</div>
<div class="form-group">
    <?= Html::submitButton('Uložiť', ['class' => 'btn btn-success save-multimedia btn-lg pull-right']) ?>
</div>

<script type="text/javascript">
    var multimediaUploadURL = "<?= Url::to(['multimedia-upload']) ?>",
        multimediaRefreshURL = "<?= Url::to(['multimedia-refresh']) ?>";
</script>
