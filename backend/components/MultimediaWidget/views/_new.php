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

$model = new MultimediaItem();

?>
<div class="form-group">
    <label class="col-sm-2 control-label">Umiestnenie</label>
    <div class="col-sm-10">
        <?= Html::activeDropDownList($model, 'multimedia_category_id',
            ArrayHelper::map(MultimediaCategory::loadAll(), 'id', 'fullName'), [
                'class' => 'form-control'
            ]) ?>
    </div>
    <div class="clearfix"></div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Súbory</label>
    <div class="col-sm-10">
        <?= FileInput::widget([
            'model' => $model,
            'attribute' => 'file',
            'options' => ['multiple' => true]
        ]) ?>
    </div>
    <div class="clearfix"></div>
</div>
