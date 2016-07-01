<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 29.06.16
 * Time: 14:55
 */

use backend\models\MultimediaItem;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$model = new MultimediaItem();

?>
<?php $form = ActiveForm::begin(['id' => 'upload-file-multimedia', 'options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="form-group">
    <label class="col-sm-2 control-label">Umiestnenie</label>
    <div class="col-sm-10">
        <?= Html::activeDropDownList($model, 'path',
            ArrayHelper::map($categories, 'path', 'fullName'), [
                'class' => 'form-control'
            ]) ?>
    </div>
    <div class="clearfix"></div>
</div>
<div class="form-group upload-multimedia-file">
    <label class="col-sm-2 control-label">Súbory</label>
    <div class="col-sm-10">
        <?= $form->field($model, 'files')->widget(FileInput::className(), [
            'options' => ['multiple' => true]
        ]) ?>
    </div>
    <div class="clearfix"></div>
</div>
<div class="form-group">
    <?= Html::submitButton('Uložiť', ['class' => 'btn btn-success']) ?>
</div>
<?php $form->end() ?>

<script type="text/javascript">
    var multimediaUploadURL = "<?= Url::to(['multimedia-upload']) ?>";
</script>
