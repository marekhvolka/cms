<?php

namespace backend\models;

/** Rozhranie pre objekty, ktore su cachovatelne
 * Interface ICacheable
 * @package backend\models
 */
interface ICacheable
{
    public function getMainCacheFile();
    public function getMainDirectory();
    public function resetAfterUpdate();
}