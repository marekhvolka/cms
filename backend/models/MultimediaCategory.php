<?php

namespace backend\models;
use backend\components\PathHelper;

/**
 * Represents a single multimedia category.
 * @package backend\models
 */
class MultimediaCategory extends Model
{
    /**
     * Path containing all categories of files.
     */
    const MULTIMEDIA_PATH = __DIR__ . '/../testing-data';

    /**
     * A name of the category.
     *
     * @var string
     */
    public $name;

    /**
     * Return the model if found, otherwise return null.
     *
     * @param $name string the name of the category
     * @return MultimediaCategory|null
     */
    public static function find($name)
    {
        if (is_dir(self::MULTIMEDIA_PATH . DIRECTORY_SEPARATOR . $name)) {
            $category = new MultimediaCategory();
            $category->name = $name;

            return $category;
        } else {
            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', function ($attribute) {
                if (strpbrk($this->$attribute, "\\/?%*:|\"<>") !== false) {
                    $this->addError($attribute, 'Meno kategórie obsahuje nepovolené znaky.');
                }
            }]
        ];
    }


    /**
     * Loads all multimedia categories
     *
     * @return array
     */
    public static function loadAll()
    {
        return array_map(function ($dir) {
            $category = new MultimediaCategory();
            $category->name = end(explode("/", $dir));

            return $category;
        }, array_filter(glob(self::MULTIMEDIA_PATH . '/*'), 'is_dir'));
    }

    /**
     * If the model is valid, saves the category.
     *
     * @param bool $validate should the model be revalidated?
     * @return bool if everything went ok
     */
    public function save($validate = true)
    {
        if (!$validate || $this->validate()) {
            $path = self::MULTIMEDIA_PATH . DIRECTORY_SEPARATOR . $this->name;
            if (!is_dir($path)) {
                return @mkdir($path, 0777);
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * If the multimedia existed with the name defined in $from, rename it to have the current name.
     *
     * @param $from string the old name
     * @return bool if the operation was successful
     */
    public function rename($from)
    {
        $old_path = self::MULTIMEDIA_PATH . DIRECTORY_SEPARATOR . $from;
        $new_name = self::MULTIMEDIA_PATH . DIRECTORY_SEPARATOR . $this->name;

        if (is_dir($old_path)) {
            return @rename($old_path, $new_name);
        } else {
            return @mkdir($new_name);
        }
    }

    /**
     * Removes the category.
     * 
     * @return bool
     */
    public function delete()
    {
        return PathHelper::remove(self::MULTIMEDIA_PATH.DIRECTORY_SEPARATOR.$this->name);
    }
}