<?php

namespace backend\models;

use backend\components\PathHelper;
use backend\controllers\BaseController;
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fullName' => 'Meno',
            'name' => 'Meno',
            'path' => 'Cesta k súboru',
            'pathForWeb' => 'Verejná cesta k súboru',
            'items' => 'Položky'
        ];
    }

    /**
     * Return the model if found, otherwise return null.
     *
     * @param $name string the name of the category
     * @param null $portal_name
     * @return MultimediaCategory|null
     * @internal param null $portal_id
     */
    public static function find($name, $portal_name = null)
    {
        if (!empty($portal_name)) {
            $portal = Portal::findOne(['name' => $portal_name]);


            $category = new MultimediaCategory();
            $category->name = $name;
            $category->path = $portal->getMultimediaDirectory() . $name;
            $category->pathForWeb = $portal->getMultimediaDirectory(true) . $name;
            $category->fullName = $category->name . ' (' . $portal->name . ')';
            $category->id = hash('md5', $category->fullName);

            return $category;
        }

        $dir_name = Yii::$app->dataEngine->getMultimediaDirectory() . $name;
        if (is_dir($dir_name)) {
            $category = new MultimediaCategory();
            $category->name = $name;
            $category->path = $dir_name;
            $category->pathForWeb = Yii::$app->dataEngine->getMultimediaDirectory(true) . $name;
            $category->fullName = $category->name . ' (spoločné pre všetky portály)';
            $category->id = hash('md5', $category->fullName);
            return $category;
        } else {
            return null;
        }
    }

    public static function fromPath($path)
    {
        $globalDir = Yii::$app->dataEngine->getMultimediaDirectory();
        $pos = mb_strpos($path, $globalDir);
        if ($pos === false) {
            $explode = explode("/", trim($path, "/"));
            $count = count($explode);

            return MultimediaCategory::find($explode[$count - 1], $explode[$count - 3]);
        } else {
            return MultimediaCategory::find(trim(str_replace($globalDir, '', $path), "/"));
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

        $portal = BaseController::$portal;

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

        usort($multimediaCategories, function ($a, $b) {
            return strcmp($a->name, $b->name);
        });

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

            usort($this->items, function ($a, $b) {
                return strcmp($a->name, $b->name);
            });
        }

        return $this->items;
    }
}