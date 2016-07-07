<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$params["menuItems"] = require(__DIR__ . '/side-menu.php');

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => [
        'log',
        'session'
    ],
    'modules' => [],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'yii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@yii/messages'
                ],
            ],
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => require('url-manager.php'),
        'urlManagerFrontend' => require('../../frontend/config/url-manager.php'),
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'booleanFormat' => ['×', '√'],
        ],
        'assetManager' => [
            'linkAssets' => true,
        ],
    ],
    'params' => $params,
    'language' => 'sk'
];
