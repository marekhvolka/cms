<?php

namespace backend\components\FileEditor\models;

use backend\components\FileEditor\FileEditorWidget;
use yii\base\Model;
use yii\web\UploadedFile;

class CreateDirectoryForm extends Model
{
    /**
     * @var string
     */
    public $directory;
    /**
     * @var UploadedFile
     */
    public $name;

    /**
     * @var string
     */
    private $baseDir = '';

    private $_builtPath = null;

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
            ['name', 'required'],
            ['directory', function ($attribute, $parameters) {
                $this->_builtPath = '/' . FileEditorWidget::normalizePath($this->baseDir . DIRECTORY_SEPARATOR . trim
                        ($this->$attribute, '/') . DIRECTORY_SEPARATOR . trim($this->name, "/"));

                if (strrpos($this->_builtPath, realpath($this->baseDir), -strlen($this->_builtPath)) === false) {
                    $this->addError($attribute, 'Invalid directory.');
                }
            }]
        ];
    }

    public function create($validate = true)
    {
        if (!$validate || $this->validate()) {
            FileEditorWidget::makePath($this->_builtPath);
        }
    }
}