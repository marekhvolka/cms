<?php
use backend\components\PathHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $categories \backend\models\MultimediaCategory[] */

?>
<?php $form = ActiveForm::begin() ?>
<div class="form-group">
    <div class="col-md-10 col-sm-offset-2">
        <div class="input-group">
            <input type="text" placeholder="Hľadať" class="form-control search-multimedia">
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<?php
foreach ($categories as $multimediaCategory) : ?>
    <div class="panel panel-default multimedia-category">
        <div class="panel-heading">
            <h4>
                <?= $multimediaCategory->fullName ?>

                <a data-toggle="collapse" href="#multimediaCategory<?= $multimediaCategory->id ?>"
                   class="pull-right">
                <span>
                    <i class="fa fa-angle-down"></i>
                </span>
                </a>
            </h4>
        </div>
        <div class="panel-body panel-collapse collapse in fixed-panel" id="multimediaCategory<?= $multimediaCategory->id ?>">
            <?php foreach ($multimediaCategory->items as $item) : ?>
                <div class="col-md-2 multimedia-item" data-name="<?= $item->name ?>">
                    <div class="thumbnail">
                        <img src="<?= (PathHelper::isImageFile($item->name)) ? ($multimediaCategory->pathForWeb . $item->name) : Url::to('/images/file.png') ?>"/>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php endforeach; ?>
<?php $form->end() ?>
