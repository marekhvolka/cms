<?php

namespace backend\models;

use backend\components\PathHelper;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Represents a single multimedia category.
 *
 * @package backend\models
 */
class MultimediaCategory extends Model
{
    /**
     * A name of the category.
     *
     * @var string
     */
    public $name;

    /**
     * Get path containing all categories of files.
     */
    public static function GET_MULTIMEDIA_PATH()
    {
        return Yii::getAlias('@frontend') . '/web/multimedia'; // WITHOUT SLASH AT THE END!!
    }

    /**
     * Return the model if found, otherwise return null.
     *
     * @param $name string the name of the category
     * @return MultimediaCategory|null
     */
    public static function find($name)
    {
        if (is_dir(self::GET_MULTIMEDIA_PATH() . DIRECTORY_SEPARATOR . $name)) {
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

            $dirsArray = explode('/', $dir);

            $category->name = end($dirsArray);

            return $category;
        }, array_filter(glob(self::GET_MULTIMEDIA_PATH() . '/*'), 'is_dir'));
    }

    /**
     * Return all possible subcategories.
     *
     * @param string $portal subcategories for a portal
     * @return array
     */
    public static function getSubcategories($portal = null)
    {
        $query = Portal::find();
        if (!empty($portal)) {
            $query = $query->where(['name' => $portal]);
        }
        return ArrayHelper::map($query->asArray(true)->all(), 'name', 'name') + ['global' => 'Spoločné pre všetky portály'];
    }

    /**
     * Remove subcategory form all categories.
     *
     * @param $id string subcategory's name
     */
    public static function removeSubcategory($id)
    {
        foreach (array_filter(glob(self::GET_MULTIMEDIA_PATH() . '/*/*'), function ($item) use ($id) {
            return is_dir($item) && end(explode("/", $item)) == $id;
        }) as $dir) {
            PathHelper::remove($dir);
        }
    }

    /**
     * Return all possible items (set their category name, subcategory, etc);
     *
     * @param null $subcategory
     * @param bool $only_images
     * @return array
     */
    public function getItems($subcategory = null, $only_images = false)
    {
        $process = function ($data, $only_images, $global, $category_name) {
            return array_map(function ($file) use ($global, $category_name) {
                $item = new MultimediaItem();
                $split_path = explode("/", $file);
                $item->name = end($split_path);
                $item->categoryName = $category_name;
                $item->subcategory = $global === true ? 'global' : $split_path[count($split_path) - 2];

                return $item;
            }, array_filter($data, function ($item) use ($only_images) {
                return is_file($item) && (!$only_images || PathHelper::isImageFile($item));
            }));
        };

        $data = [];

        if ($subcategory == null || $subcategory == 'global') {
            $data = $process(glob(self::GET_MULTIMEDIA_PATH() . DIRECTORY_SEPARATOR . $this->name . '/*'), $only_images, true, $this->name);

            if ($subcategory == 'global') {
                return $data;
            }
        }

        $data += $process(glob(self::GET_MULTIMEDIA_PATH() . DIRECTORY_SEPARATOR . $this->name . DIRECTORY_SEPARATOR . (($subcategory == null) ? '*/*' : $subcategory . DIRECTORY_SEPARATOR . '*')), $only_images, false, $this->name);

        return $data;
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
            $path = self::GET_MULTIMEDIA_PATH() . DIRECTORY_SEPARATOR . $this->name;
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
        $old_path = self::GET_MULTIMEDIA_PATH() . DIRECTORY_SEPARATOR . $from;
        $new_name = self::GET_MULTIMEDIA_PATH() . DIRECTORY_SEPARATOR . $this->name;

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
        return PathHelper::remove(self::GET_MULTIMEDIA_PATH() . DIRECTORY_SEPARATOR . $this->name);
    }
}