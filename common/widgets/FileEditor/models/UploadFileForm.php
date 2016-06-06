<?php

namespace common\widgets\FileEditor\models;


use common\widgets\FileEditor\FileEditorWidget;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadFileForm extends Model
{
    /**
     * @var string
     */
    public $directory;
    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * @var string
     */
    private $baseDir = '';

    /**
     * UploadFileForm constructor.
     * @param string $baseDir
     */
    public function __construct($baseDir)
    {
        parent::__construct();
        $this->baseDir = $baseDir;
    }


    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false],
            ['directory', function ($attribute, $parameters) {
                $realpath = '/' . FileEditorWidget::normalizePath($this->baseDir . DIRECTORY_SEPARATOR . trim($this->$attribute, '/'));

                if (strrpos($realpath, realpath($this->baseDir), -strlen($realpath)) === false) {
                    $this->addError($attribute, 'Invalid directory.');
                } else {
                    FileEditorWidget::makePath($realpath);
                }
            }]
        ];
    }

    public function upload($validate = true)
    {
        if (!$validate || $this->validate()) {
            $path = $this->baseDir . DIRECTORY_SEPARATOR . $this->directory . DIRECTORY_SEPARATOR .
                $this->file->baseName . '.' . $this->file->extension;
            $this->file->saveAs($path);
            return $path;
        } else {
            return false;
        }
    }
}