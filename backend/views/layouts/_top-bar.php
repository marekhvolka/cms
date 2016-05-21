<?php
use backend\models\Portal;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$session = Yii::$app->session;

$portal = Portal::find()
    ->where(['id' => $session->get('portal_id')])
    ->one();
$portalName = isset($portal->name) ? $portal->name : '';

NavBar::begin([
    //'brandLabel'           => Html::img('@web/images/logo_white.png', ['alt' => 'Logo', 'class' => 'brand-logo']),
    //'brandUrl'             => Yii::$app->homeUrl,
    'renderInnerContainer' => false,
    'options'              => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

$items = [];
$portals = Portal::find()->all();
foreach ($portals as $portal) {
    $item = [
        'label' => $portal->name,
        'url' => Url::to(['/portal/change-current-portal/', 'id' => $portal->id]),
    ];
    $items[] = $item;
}

echo Nav::widget([
    'options' => [
        'class' => 'navbar-nav',
        'id' => 'portal-nav',
    ],
    'items'   => [
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
        'links'    => $this->params['breadcrumbs']
    ]);
}

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
        'items'   => $loginMenu,

    ]);
}


NavBar::end();
