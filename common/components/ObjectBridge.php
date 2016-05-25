<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 24.05.16
 * Time: 16:54
 */


class ObjectBridge extends ArrayObject
{
    public $obj;

    public function __construct(&$obj) {
        $this->obj = $obj;
    }

    public function __get($a)
    {
        if(isset($this->obj->$a))
        {
            return $this->obj->$a;
        }
        else
        {
            // return an empty object in order to prevent errors with chain call
            $tmp = new stdClass();
            return new ObjectBridge($tmp);
        }
    }

    public function __set($key,$value)
    {
        $this->obj->$key = $value;
    }
    public function __call($method,$args)
    {
        call_user_func_array(Array($this->obj,$method),$args);
    }
    public function __toString()
    {
        return "";
    }
}