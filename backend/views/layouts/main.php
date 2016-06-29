<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use backend\components\AjaxLoading\AjaxLoadingWidget;
use common\widgets\Box;
use common\widgets\Navigation;
use yii\helpers\Html;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="wrapper">
    <?= $this->render('_top-bar') ?>
    <?= Navigation::widget([
        'items' => Yii::$app->params['menuItems']
    ]) ?>
    <div id="page-wrapper">
        <?= Alert::widget() ?>
        <?php if (!empty($this->title)) : ?>

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-12">
                    <h1><?= Html::encode($this->title) ?>
                        <span class="top-bar-buttons">
                            <?php if (isset($this->blocks['button'])): ?>
                            <?= $this->blocks['button'] ?>
                            <?php endif; ?>
                        </span>
                    </h1>
                    <?php
                    if (!empty($this->params['page-head-btn'])) {
                        echo '<div class="page-head-btn-footer">' . $this->params['page-head-btn'] . '</div>';
                    }
                    ?>
                </div>
            </div>

        <?php endif; ?>
        <?php Box::begin() ?>
        <?= $content ?>
        <?php Box::end() ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
    </div>
</footer>

<?= AjaxLoadingWidget::widget() ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>