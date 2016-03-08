<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use kartik\sidenav\SideNav;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
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
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    echo Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        'options' => ['class' => 'navbar-nav nav breadcrumb-nav'],
    ]);

    if (Yii::$app->user->isGuest) {
        $loginMenu[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $loginMenu[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }

    /*echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav side-nav '],
        'items' => $this->params['menuItems'],
        'encodeLabels' => false
    ]);*/

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $loginMenu,
    ]);

    NavBar::end();
    ?>

    <div class="container">
        <?= Alert::widget() ?>
        <div class="row">
            <div class="col-md-2">
             <?php
             echo SideNav::widget([
                 'encodeLabels' => false,
                 'options' => ['class' => 'nav navbar-nav side-nav '],
                 'items' => $this->params['menuItems'],
             ]);

             ?>
            </div>
            <div class="col-md-10">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
