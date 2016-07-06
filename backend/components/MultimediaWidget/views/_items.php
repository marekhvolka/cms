<?php
use backend\components\PathHelper;
use yii\helpers\Url;

foreach ($categories as $multimediaCategory) {
    if (count($multimediaCategory->items) > 0) {
        ?>
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
            <div class="panel-body panel-collapse collapse in fixed-panel"
                 id="multimediaCategory<?= $multimediaCategory->id ?>">
                <?php foreach ($multimediaCategory->items as $item) {
                    $is_image = PathHelper::isImageFile($item->name);
                    ?>
                    <div class="col-md-2 multimedia-item <?php if ($is_image) {
                        echo 'multimedia-image';
                    } ?>" data-name="<?= $item->name ?>" data-path-for-web="<?= $multimediaCategory->pathForWeb . $item->name?>">
                        <div class="thumbnail">
                            <div class="caption">
                                <?= $item->name ?>
                            </div>

                            <img
                                src="<?= ($is_image) ? ($multimediaCategory->pathForWeb . $item->name) : Url::to(['/images/file.png']) ?>"/>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

    <?php }
} ?>