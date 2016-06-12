<?php

namespace backend\models;

use backend\components\PathHelper;
use yii\helpers\ArrayHelper;

/**
 * Represents a single multimedia category.
 *
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
     * Return all possible subcategories.
     *
     * @param integer $portal subcategories for a portal
     * @return array
     */
    public static function getSubcategories($portal = null)
    {
        $query = Portal::find();
        if (!empty($portal)) {
            $query = $query->where(['id' => $portal]);
        }
        return ArrayHelper::map($query->asArray(true)->all(), 'id', 'name') + ['global' => 'Spoločné pre všetky portály'];
    }

    /**
     * Remove subcategory form all categories.
     *
     * @param $id string subcategory's name
     */
    public static function removeSubcategory($id)
    {
        foreach (array_filter(glob(self::MULTIMEDIA_PATH . '/*/*'), function ($item) use ($id) {
            return is_dir($item) && end(explode("/", $item)) == $id;
        }) as $dir) {
            PathHelper::remove($dir);
        }
    }

    /**
     * Return all possible items (set their category name, subcategory, etc);
     *
     * @param null $subcategory
     * @return array
     */
    public function getItems($subcategory = null)
    {
        return array_map(function ($file) {
            $item = new MultimediaItem();
            $split_path = explode("/", $file);
            $item->name = end($split_path);
            $item->categoryName = $this->name;
            $item->subcategory = $split_path[count($split_path) - 2];

            return $item;
        }, array_filter(glob(self::MULTIMEDIA_PATH . DIRECTORY_SEPARATOR . $this->name . DIRECTORY_SEPARATOR . (($subcategory == null) ? '*/*' : $subcategory . DIRECTORY_SEPARATOR . '*')), 'is_file'));
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
        return PathHelper::remove(self::MULTIMEDIA_PATH . DIRECTORY_SEPARATOR . $this->name);
    }
}