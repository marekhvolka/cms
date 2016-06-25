<?php

namespace backend\models;

use backend\components\PathHelper;
use yii\base\Model;
use yii\web\UnauthorizedHttpException;
use yii\web\UploadedFile;

/**
 * Represents one file in a subcategory of a category.
 *
 * @package backend\models
 */
class MultimediaItem extends Model
{
    /**
     * Uploading a new file scenario.
     */
    const SCENARIO_UPLOAD = 'upload';

    /**
     * @var string The name of the subcategory.
     */
    public $subcategory = 'global';
    /**
     * @var string the name of the category
     */
    public $categoryName;
    /**
     * @var string the name of the file
     */
    public $name;
    /**
     * @var UploadedFile the new file in case of upload scenario
     */
    public $file;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false],
            [['name', 'categoryName', 'subcategory'], 'required'],
            [['name', 'subcategory'], function ($attribute) {
                if (strpbrk($this->$attribute, "\\/?%*:|\"<>") !== false) {
                    $this->addError($attribute, 'Meno súboru obsahuje nepovolené znaky.');
                }
            }]
        ];
    }

    /**
     * Find a particular MultimediaItem. Return null if not found.
     *
     * @param $categoryName string the category of the item
     * @param $subcategory string the subcategory of the item
     * @param $name string the name of the item
     * @return MultimediaItem|null
     */
    public static function find($categoryName, $subcategory, $name)
    {
        if (is_file(MultimediaCategory::GET_MULTIMEDIA_PATH() . DIRECTORY_SEPARATOR . $categoryName . DIRECTORY_SEPARATOR . ($subcategory == 'global' ? $name : $subcategory . DIRECTORY_SEPARATOR . $name))) {
            $item = new MultimediaItem();
            $item->name = $name;
            $item->categoryName = $categoryName;
            $item->subcategory = $subcategory;

            return $item;
        } else {
            return null;
        }
    }

    /**
     * Get content of the file.
     * @return string
     */
    public function getContent()
    {
        $path = realpath($this->getPath());

        return file_get_contents($path);
    }

    /**
     * Return the path to the file.
     * @return string
     * @throws UnauthorizedHttpException in case of an illegal access to a file
     */
    public function getPath()
    {
        $path = realpath(MultimediaCategory::GET_MULTIMEDIA_PATH() . DIRECTORY_SEPARATOR . $this->categoryName . DIRECTORY_SEPARATOR . ($this->subcategory == 'global' ? $this->name : $this->subcategory . DIRECTORY_SEPARATOR . $this->name));

        if (PathHelper::isInside($path, realpath(MultimediaCategory::GET_MULTIMEDIA_PATH()))) {
            return $path;
        } else {
            throw new UnauthorizedHttpException();
        }
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['name', 'categoryName', 'subcategory'],
            self::SCENARIO_UPLOAD  => ['file', 'categoryName', 'subcategory']
        ];
    }

    /**
     * Upload the new file, so that the new multimedia item gets saved.
     *
     * @return bool the successfulness of the operation
     */
    public function upload()
    {
        if ($this->validate(['file', 'categoryName', 'subcategory'])) {
            $dir = MultimediaCategory::GET_MULTIMEDIA_PATH() . DIRECTORY_SEPARATOR . $this->categoryName . ($this->subcategory == "global" ? '' : DIRECTORY_SEPARATOR . $this->subcategory);
            PathHelper::makePath($dir);

            return $this->file->saveAs($dir . DIRECTORY_SEPARATOR . $this->file->getBaseName() . '.' . $this->file->getExtension());
        }

        return false;
    }

    /**
     * Delete the item.
     */
    public function delete()
    {
        $path = $this->getPath();

        if (is_file($path)) {
            PathHelper::remove($path);
        }
    }
}