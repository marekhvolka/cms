<?php

namespace backend\components\FileEditor\models;

use backend\components\PathHelper;
use yii\base\Model;

/**
 * Used to create a new directory.
 * @package common\widgets\FileEditor\models
 */
class CreateDirectoryForm extends Model
{
    /**
     * The directory into which the new dir should be put in.
     *
     * @var string
     */
    public $directory;
    /**
     * The name of the directory, may be even another path.
     *
     * @var string
     */
    public $name;

    /**
     * The base / root directory to the directory be put in.
     *
     * @var string
     */
    private $baseDir;

    /**
     * The built path.
     *
     * @var string
     */
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['directory', function ($attribute) {
                $this->buildPath();

                if (PathHelper::isInside($this->_builtPath, realpath($this->baseDir))) {
                    $this->addError($attribute, 'Invalid directory.');
                }
            }]
        ];
    }

    /**
     * Create the directory if the model is valid.
     *
     * @param bool $validate should the model be validated?
     */
    public function create($validate = true)
    {
        if (!$validate || $this->validate()) {
            if(empty($this->_builtPath)){
                $this->buildPath();
            }
            PathHelper::makePath($this->_builtPath);
        }
    }

    /**
     * Build the _builtPath field.
     */
    private function buildPath()
    {
        $this->_builtPath = '/' . PathHelper::normalizePath($this->baseDir . DIRECTORY_SEPARATOR . trim
                ($this->directory, '/') . DIRECTORY_SEPARATOR . trim($this->name, "/"));
    }
}