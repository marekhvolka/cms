<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'cacheEngine' => [
            'class' => 'common\components\CacheEngine',
        ],
    ],
];
