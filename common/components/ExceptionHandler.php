<?php
use yii\helpers\VarDumper;

/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 25.05.16
 * Time: 22:08
 */
class ExceptionHandler
{
    public static function handleException($exception)
    {
        //VarDumper::dump($exception);

        /*$systemException = new \backend\models\SystemException();
        $systemException->message = $exception->getMessage();

        $systemException->save();*/
    }
}