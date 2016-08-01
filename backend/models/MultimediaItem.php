<?php

namespace backend\models;

use backend\components\PathHelper;
use Yii;
use yii\base\Model;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;
use yii\web\UploadedFile;

/**
 * Trieda, reprezentujuca subor (obrazok, dokument, ...) v multimediach
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
     * @var string the name of the file
     */
    public $name;
    /**
     * @var UploadedFile[] the new file in case of upload scenario
     */
    public $files;

    public $path;

    public $multimedia_category_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['files'], 'each', "rule" => ['file', 'skipOnEmpty' => false]],
            [['path'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Meno položky',
            'files' => 'Súbory',
            'path' => 'Cesta',
            'multimedia_category_id' => 'ID kategórie'
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['name'],
            self::SCENARIO_UPLOAD => ['files', 'path']
        ];
    }

    /**
     * Upload the new file, so that the new multimedia item gets saved.
     *
     * @return bool the successfulness of the operation
     */
    public function upload()
    {
        if ($this->validate(['files', 'path'])) {
            PathHelper::makePath($this->path);


            foreach($this->files as $file){

                if(!$file->saveAs($this->path . DIRECTORY_SEPARATOR . $file->getBaseName() . '.' . $file->getExtension())){
                    return false;
                };
            }

            return true;
        }

        return false;
    }

    /**
     * Delete the item.
     */
    public function delete()
    {
        $path = $this->path . DIRECTORY_SEPARATOR . $this->name;

        if (is_file($path)) {
            PathHelper::remove($path);
        }
    }
}