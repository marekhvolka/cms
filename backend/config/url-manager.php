<?php

return [
    'class' => 'yii\web\UrlManager',
    'showScriptName' => false, // Disable index.php
    'enablePrettyUrl' => true, // Disable r= routes
    
    'rules' => require('routes.php'),
];
