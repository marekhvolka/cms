<?php
/**
 * Created by PhpStorm.
 * User: MarekHvolka
 * Date: 21.06.16
 * Time: 18:10
 */

namespace backend\models;


/*
 * @property bool $existing Indicates if model already exists.
 * @property bool $removed Indicates if model has to be removed
 */

class CustomModel extends \yii\db\ActiveRecord
{
    public $existing;
    public $removed = true;

    public static function loadFromData($models, $item, $index, $modelClassName)
    {
        if (!empty($models[$index])) {
            $models[$index]->load($item, '');
            $models[$index]->existing = $item['existing'];
            $models[$index]->removed = false;
        }
        else {
            $models[$index] = new $modelClassName();
            $models[$index]->load($item, '');
            $models[$index]->removed = false;
        }
    }

    public function beforeSave($insert)
    {
        if (!$this->existing) {
            unset($this->id);
        }

        if ($this->removed) {
            $this->delete();
            return true;
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
}