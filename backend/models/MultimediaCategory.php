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

    public $portal;

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
        $multimediaCategories = array();

        $portal = Portal::findOne(Yii::$app->session->get('portal_id'));

        chdir($portal->getMultimediaDirectory());

        $directories = glob('*', GLOB_ONLYDIR);

        foreach ($directories as $directory) {
            $category = new MultimediaCategory();
            $category->name = $directory;
            $category->portal = $portal;
            $category->path = $portal->getMultimediaDirectory() . $directory . '/';
            $category->pathForWeb = $portal->getMultimediaDirectoryForWeb() . $directory . '/';
            $category->fullName = $category->portal->name . ' ' . $category->name;

            $category->id = hash('md5', $category->fullName);

            $multimediaCategories[] = $category;
        }

        chdir(Yii::$app->dataEngine->getMultimediaDirectory());

        $directories = glob('*', GLOB_ONLYDIR);

        foreach ($directories as $directory) {
            $category = new MultimediaCategory();
            $category->name = $directory;
            $category->path = Yii::$app->dataEngine->getMultimediaDirectory() . $directory . '/';
            $category->pathForWeb = Yii::$app->dataEngine->getMultimediaDirectoryForWeb() . $directory . '/';
            $category->fullName = $category->name;

            $category->id = hash('md5', $category->fullName);

            $multimediaCategories[] = $category;
        }

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
                $item = new MultimediaItem();
                $item->name = $file;
                $item->multimedia_category_id = $this->id;

                $item->type = MultimediaItem::determineType($file);

                $this->items[] = $item;
            }
        }

        return $this->items;
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