<?php
use backend\models\SystemException;

/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 24.05.16
 * Time: 16:54
 */

/** Pomocná trieda, ktorá obaľuje všetky premenné. Vďaka nej dokážeme logovať všetky chybné prístupy k hodnotám premenných
 * Class ObjectBridge
 */
class ObjectBridge extends ArrayObject
{
    public $obj;
    public $string;

    public function __construct(&$obj, $string)
    {
        $this->obj = $obj;
        $this->string = $string;
    }

    public function __get($a)
    {
        if (isset($this->obj->$a)) {
            $var = $this->obj->$a;

            return $var;
        } else {
            // return an empty object in order to prevent errors with chain call
            $tmp = new stdClass();

            /*$exception = new SystemException();
            $exception->message = 'Chyba - nedefinovaná hodnota premennej ' . get_class($this->obj) . ' - ' . $a;

            $exception->save();*/

            return new ObjectBridge($tmp, '');
        }
    }

    public function __set($key, $value)
    {
        $this->obj->$key = $value;
    }

    public function __call($method, $args)
    {
        call_user_func_array(Array($this->obj, $method), $args);
    }

    public function __isset($name)
    {
        return isset($this->obj->$name);
    }

    public function __toString()
    {
        return '' . $this->string;
    }
}

function executeScript($path)
{
    ob_start();
    include $path;
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
}