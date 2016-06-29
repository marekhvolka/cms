<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 29.06.16
 * Time: 14:55
 */
use backend\models\MultimediaCategory;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin() ?>
<div class="form-group">
    <div class="col-md-10 col-sm-offset-2">
        <div class="input-group">
            <input type="text" placeholder="Hľadať" class="form-control">
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<?php
foreach (MultimediaCategory::loadAll() as $multimediaCategory) : ?>

    <div class="panel panel-default">
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
        <div class="panel-body panel-collapse collapse in" id="multimediaCategory<?= $multimediaCategory->id ?>">
            <?php foreach ($multimediaCategory->items as $item) : ?>
                <div class="col-md-2">
                    <div class="thumbnail">
                        <img src="<?= $multimediaCategory->pathForWeb . $item->name ?>"/>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php endforeach; ?>
<?php $form->end() ?>
