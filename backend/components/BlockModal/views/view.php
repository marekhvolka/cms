<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 06.06.16
 * Time: 11:00
 */
use backend\assets\AppAsset;
use backend\components\AjaxLoading\AjaxLoadingWidget;
use backend\models\Block;
use yii\bootstrap\Html;

/* @var $model Block */
/* @var $htmlBody bool */

AppAsset::register($this);

if(!isset($htmlBody)){
    $htmlBody = false;
}
?>
<style>
    .modal-dialog {
        width: 1000px !important;
    }
</style>

<?php if($htmlBody) : ?>
<?php $this->beginPage() ?>
<html>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php endif; ?>
<?php
switch ($model->type) {
    case 'product_snippet' :

    case 'portal_snippet' :

    case 'snippet' :

        echo $this->render('_snippet', [
            'model' => $model,
            'productType' => $productType
        ]);

        break;
    case 'text' :

        echo $this->render('_text', ['model' => $model]);

        break;
    case 'html' :

        echo $this->render('_html', ['model' => $model]);

        break;
}
?>
<?php if ($htmlBody) : ?>
<?= AjaxLoadingWidget::widget() ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<?php endif; ?>


