<?php
use yii\bootstrap\Alert;

$session = Yii::$app->getSession();
if ($session->hasFlash('alerts')) {
    foreach ($session->getFlash('alerts') as $flash) {
        echo Alert::widget([
            'options' => [
                'class' => 'alert-' . $flash->type
            ],
            'body' => $flash->text
        ]);
    }
}
