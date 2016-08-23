<?php

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

    public function hasTag($tag)
    {
        if (!isset($this->obj->tags) || !isset($tag)) {
            return false;
        }

        if (key_exists($tag->id, $this->obj->tags)) {
            return true;
        }
        return false;
    }

    /** Funkcia, ktora vrati, ci ma dany produkt aktualne akciu
     * @return bool
     */
    public function hasDiscount()
    {
        if (!isset($this->obj) || !isset($this->obj->platnost_akcie)) {
            return false;
        }
        if (time() < strtotime($this->obj->platnost_akcie)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Funkcia ktora vrati, ci je produkt aktivny - mame spolupracu
     */
    public function isAvailable()
    {
        if (!isset($this->obj) || !isset($this->obj->typ_spoluprace)) {
            return false;
        }

        if ($this->obj->typ_spoluprace == 'bez_spoluprace')
            return false;

        return true;
    }

    public function isApi()
    {
        if (!isset($this->obj) || !isset($this->obj->typ_spoluprace)) {
            return false;
        }

        if ($this->obj->typ_spoluprace == 'api')
            return true;

        return false;
    }

    public function isIframe()
    {
        if (!isset($this->obj) || !isset($this->obj->typ_spoluprace)) {
            return false;
        }

        if ($this->obj->typ_spoluprace == 'api' || $this->obj->typ_spoluprace == 'iframe')
            return true;

        return false;
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