<?php

namespace backend\models;
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 19.06.16
 * Time: 19:34
 */

interface ICacheable
{
    public function getMainCacheFile($reload = false);
    public function getMainDirectory();
    public function resetAfterUpdate();
}