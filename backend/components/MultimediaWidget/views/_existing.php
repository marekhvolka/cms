<?php
use backend\components\PathHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $categories \backend\models\MultimediaCategory[] */

?>
<div class="form-group">
    <div class="col-md-10 col-sm-offset-2">
        <div class="input-group">
            <input type="text" placeholder="Hľadať" class="form-control search-multimedia">
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="multimedia-categories">
    <?= $this->render('_items', ['categories' => $categories, 'onlyImages' => $onlyImages]) ?>
</div>
