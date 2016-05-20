<?php

return  [
            '<module>/<controller>/<action>/<id:[a-zA-Z0-9-]+>/<id2:[a-zA-Z0-9-]+>' => '<module>/<controller>/<action>/',
            '<module>/<controller>/<action>/<id:[a-zA-Z0-9-]+>/<type:[a-zA-Z0-9-]+>' => '<module>/<controller>/<action>/',
            '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
        ]
?>
