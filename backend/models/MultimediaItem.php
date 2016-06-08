<?php

namespace backend\models;

use backend\components\PathHelper;
use yii\web\UploadedFile;

class MultimediaItem extends Model
{
    const SCENARIO_UPLOAD = 'upload';

    public $subcategory = 'global';
    public $categoryName;
    public $name;
    /**
     * @var UploadedFile
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

    public static function find($categoryName, $subcategory, $name)
    {
        if (is_file(MultimediaCategory::MULTIMEDIA_PATH . DIRECTORY_SEPARATOR . $categoryName . DIRECTORY_SEPARATOR . $subcategory . DIRECTORY_SEPARATOR . $name)) {
            $item = new MultimediaItem();
            $item->name = $name;
            $item->categoryName = $categoryName;
            $item->subcategory = $subcategory;
            return $item;
        } else {
            return false;
        }
    }

    public function getContent(){
        return file_get_contents(MultimediaCategory::MULTIMEDIA_PATH . DIRECTORY_SEPARATOR . $this->categoryName . DIRECTORY_SEPARATOR . $this->subcategory . DIRECTORY_SEPARATOR . $this->name);
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

    public function upload()
    {
        if ($this->validate(['file', 'categoryName', 'subcategory'])) {
            $dir = MultimediaCategory::MULTIMEDIA_PATH . DIRECTORY_SEPARATOR . $this->categoryName . DIRECTORY_SEPARATOR . $this->subcategory;
            PathHelper::makePath($dir);

            return $this->file->saveAs($dir . DIRECTORY_SEPARATOR . $this->file->getBaseName() . '.' . $this->file->getExtension());
        }

        return false;
    }

    public function delete(){
        $path = MultimediaCategory::MULTIMEDIA_PATH . DIRECTORY_SEPARATOR . $this->categoryName . DIRECTORY_SEPARATOR . $this->subcategory . DIRECTORY_SEPARATOR . $this->name;

        if(is_file($path)){
            PathHelper::remove($path);
        }
    }
}