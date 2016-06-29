<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'dataEngine' => [
            'class' => 'common\components\DataEngine',
        ],
    ],
];
