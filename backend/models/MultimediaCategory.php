<?php

namespace backend\models;

use backend\components\PathHelper;
use Yii;
use yii\base\Model;

/**
 * Represents a single multimedia category.
 *
 * @property $items[] MultimediaItem
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

    public $fullName;

    public $path;

    public $pathForWeb;

    private $items;

    public $id;

    /**
     * Return the model if found, otherwise return null.
     *
     * @param $name string the name of the category
     * @return MultimediaCategory|null
     */
    public static function find($name)
    {
        if (is_dir(Yii::$app->dataEngine->getMultimediaDirectory() . $name)) {
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
            [
                'name',
                function ($attribute) {
                    if (strpbrk($this->$attribute, "\\/?%*:|\"<>") !== false) {
                        $this->addError($attribute, 'Meno kategórie obsahuje nepovolené znaky.');
                    }
                }
            ]
        ];
    }


    /**
     * Loads all multimedia categories
     *
     * @return array
     */
    public static function loadAll()
    {
        /**
         * @param array $dirs
         * @param $basePath
         * @param $basePathForWeb
         * @param Portal $portal
         * @return array
         */
        $processDirs = function (array $dirs, $basePath, $basePathForWeb, $portal = null) {
            $result = [];

            foreach ($dirs as $directory) {
                $category = new MultimediaCategory();
                $category->name = $directory;
                $category->path = $basePath . $directory . '/';
                $category->pathForWeb = $basePathForWeb . $directory . '/';
                $category->fullName = $category->name . ' (' . ($portal != null ? $portal->name : 'spoločné pre všetky portály') . ')';
                $category->id = hash('md5', $category->fullName);
                $result[] = $category;
            }

            return $result;
        };

        $multimediaCategories = [];

        $portal = Portal::findOne(Yii::$app->session->get('portal_id'));

        if ($portal) {
            chdir($portal->getMultimediaDirectory()); // so that we get only directory name as result of glob
            $multimediaCategories = array_merge($multimediaCategories, $processDirs(
                glob('*', GLOB_ONLYDIR),
                $portal->getMultimediaDirectory(),
                $portal->getMultimediaDirectory(true),
                $portal
            ));
        }

        chdir(Yii::$app->dataEngine->getMultimediaDirectory()); // so that we get only directory name as result of glob
        $multimediaCategories = array_merge($multimediaCategories, $processDirs(
            glob('*', GLOB_ONLYDIR),
            Yii::$app->dataEngine->getMultimediaDirectory(),
            Yii::$app->dataEngine->getMultimediaDirectory(true)
        ));

        return $multimediaCategories;
    }

    /**
     * Return all possible items (set their category name, subcategory, etc);
     *
     * @param bool $only_images
     * @return array
     */
    public function getItems($only_images = false)
    {
        if (!isset($this->items)) {

            $this->items = array();
            chdir($this->path);

            foreach (glob('*') as $file) {
                if (!$only_images || PathHelper::isImageFile($file)) {
                    $item = new MultimediaItem();
                    $item->name = $file;
                    $this->items[] = $item;
                }
            }
        }

        return $this->items;
    }

    /**
     * If the multimedia existed with the name defined in $from, rename it to have the current name.
     *
     * @param $from string the old name
     * @return bool if the operation was successful
     */
    public function rename($to)
    {
        $new_name = explode("/", $this->path);
        $new_name[count($new_name - 1)] = $to;
        $new_name = join("/", $new_name);


        if (is_dir($this->path)) {
            rename($this->path, $new_name);
        } else {
            mkdir($new_name);
        }

        $this->path = $new_name;
        $this->pathForWeb = explode('/', $this->pathForWeb);
        $this->pathForWeb[count($this->pathForWeb - 1)] = $to;
        $this->pathForWeb = join("/", $this->pathForWeb);
    }

    /**
     * Removes the category.
     *
     * @return bool
     */
    public function delete()
    {
        return PathHelper::remove($this->path);
    }
}