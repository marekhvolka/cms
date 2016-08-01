<?php

namespace backend\models;

/** Rozhranie, urcujuce, ze objekt je duplikovatelny
 * Interface IDuplicable
 * @package backend\models
 */
interface IDuplicable
{
    public function prepareToDuplicate();
}