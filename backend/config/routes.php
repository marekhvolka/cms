<?php

return  [
            '<module>/<controller>/<action>/<id:[a-zA-Z0-9-]+>/<id2:[a-zA-Z0-9-]+>' => '<module>/<controller>/<action>/',
            '<module>/<controller>/<action>/<id:[a-zA-Z0-9-]+>/<type:[a-zA-Z0-9-]+>' => '<module>/<controller>/<action>/',
            '<module>/<controller>/<action>/<type:[a-zA-Z0-9-]+>' => '<module>/<controller>/<action>/',
            '<controller:[a-zA-Z0-9_-]+>/<action:[a-zA-Z0-9_-]+>/<id:\d+>' => '<controller>/<action>',
        ]
?>
