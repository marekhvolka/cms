<?php

return [
    'class' => 'yii\web\UrlManager',
    'showScriptName' => false,
    'enablePrettyUrl' => true,
    'enableStrictParsing' => false,
    'rules' => require('routes.php'),
];