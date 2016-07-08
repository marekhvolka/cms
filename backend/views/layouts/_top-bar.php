<?php
use backend\controllers\BaseController;
use backend\models\Portal;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */


$portal = Portal::find()
    ->where(['id' => BaseController::$portal])
    ->one();
$portalName = isset($portal->name) ? $portal->name : '';

NavBar::begin([
    /*'brandLabel' => Html::img('@web/images/logo_white.png', ['alt' => 'Logo', 'class' => 'brand-logo']),
    'brandUrl' => Yii::$app->homeUrl,*/
    'renderInnerContainer' => false,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

$items = [];
$portals = Portal::find()->all();
foreach ($portals as $portal) {
    $item = [
        'label' => $portal->name,
        'url' => Url::current(['change-portal' => $portal->id]),
    ];
    $items[] = $item;
}

echo Nav::widget([
    'options' => [
        'class' => 'navbar-nav',
        'id' => 'portal-nav',
    ],
    'items' => [
        [
            'label' => $portalName,
            'items' => $items
        ]
    ],
]);

if (!empty($this->params['breadcrumbs'])) {
    echo Breadcrumbs::widget([
        'options' => [
            'class' => 'navbar-nav nav',
            'id' => 'breadcrumbs',
        ],
        'homeLink' => false,
        'links' => $this->params['breadcrumbs']
    ]);
}

$this->registerJs("var globalSearchUrl = \"" . Url::to(['global-search-results']) . "\";", \yii\web\View::POS_END);
?>
    <div class="global-search">
        <?= Html::input('string', 'globalSearch', null, [
            'id' => 'global-search-input',
            'placeholder' => 'Globálne vyhľadávanie',
            'class' => 'form-control',
            'autofocus' => 'autofocus',
            'autocomplete' => 'off'
        ]) ?>
        <ul class="data">
            <li>Žiadne výsledky</li>
        </ul>
    </div>
<?php

if (!Yii::$app->user->isGuest) {
    $loginMenu[] = '<li>'
        . Html::beginForm(['/site/logout'], 'post')
        . Html::submitButton(
            'Odhlásiť (' . Yii::$app->user->identity->username . ')',
            ['class' => 'btn btn-link']
        )
        . Html::endForm()
        . '</li>';

    echo Nav::widget([
        'options' => [
            'class' => 'navbar-nav navbar-right',
            'id' => 'login-box'
        ],
        'items' => $loginMenu,

    ]);
}

NavBar::end();