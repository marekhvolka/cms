<?php

namespace backend\components\FileEditor\models;

use backend\components\PathHelper;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Used to upload a new file.
 *
 * @package common\widgets\FileEditor\models
 */
class UploadFileForm extends Model
{
    /**
     * The directory into which the uploaded file should be put in.
     * @var string
     */
    public $directory;
    /**
     * The uploaded file.
     *
     * @var UploadedFile
     */
    public $file;

    /**
     * The base / root directory to the file be put in.
     *
     * @var string
     */
    private $baseDir;

    /**
     * UploadFileForm constructor.
     * @param string $baseDir
     */
    public function __construct($baseDir)
    {
        parent::__construct();
        $this->baseDir = $baseDir;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false],
            ['directory', function ($attribute) {
                $realpath = '/' . PathHelper::normalizePath($this->baseDir . DIRECTORY_SEPARATOR . trim($this->$attribute, '/'));

                if (!PathHelper::isInside($realpath, realpath($this->baseDir))) {
                    $this->addError($attribute, 'Invalid directory.');
                }
            }]
        ];
    }

    /**
     * If the model is valid (or the $validate param is false), upload the file.
     *
     * @param bool $validate check model's validity
     * @return string the path to which the file is put in
     */
    public function upload($validate = true)
    {
        if (!$validate || $this->validate()) {
            $path = $this->baseDir . DIRECTORY_SEPARATOR . $this->directory;

            PathHelper::makePath(PathHelper::normalizePath($path));

            $path .= DIRECTORY_SEPARATOR . $this->file->baseName . '.' . $this->file->extension;
            $this->file->saveAs($path);

            return $path;
        }
    }
}