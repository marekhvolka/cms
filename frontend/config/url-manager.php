<?php

return [
    'class' => 'yii\web\UrlManager',
    'showScriptName' => false,
    'enablePrettyUrl' => true,
    'rules' => require('routes.php'),
];