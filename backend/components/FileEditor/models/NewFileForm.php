<?php

namespace backend\components\FileEditor\models;

use backend\components\PathHelper;
use yii\base\Model;

/**
 * Used to create a file.
 *
 * @package common\widgets\FileEditor\models
 */
class NewFileForm extends Model
{
    /**
     * The new content of the file.
     *
     * @var string
     */
    public $text;

    /**
     * The name of the file to be edited.
     *
     * @var string
     */
    public $name;

    /**
     * The directory to which the file belongs to.
     *
     * @var string
     */
    public $directory;

    /**
     * The base / root directory to the directory be put in.
     *
     * @var string
     */
    private $baseDir;

    /**
     * @param string $baseDir the base dir
     */
    public function __construct($baseDir)
    {
        parent::__construct();
        $this->baseDir = realpath($baseDir);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['text', 'safe'],
            ['directory', function ($attribute) {
                if (!PathHelper::isInside(DIRECTORY_SEPARATOR . PathHelper::normalizePath($this->getFullPath()), realpath($this->baseDir))) {
                    $this->addError($attribute, 'Nevalídny súbor.');

                    return;
                }
            }]
        ];
    }

    /**
     * Save the content of the file.
     * @param $validate
     */
    public function save($validate)
    {
        if (!$validate || $this->validate()) {
            file_put_contents($this->getFullPath(), $this->text);
        }
    }

    /**
     * Return the full path to the file.
     *
     * @return string the path
     */
    public function getFullPath()
    {
        return DIRECTORY_SEPARATOR . $this->baseDir . DIRECTORY_SEPARATOR . $this->getRelativePath();
    }

    public function getRelativePath()
    {
        return trim($this->directory, "/") . DIRECTORY_SEPARATOR . trim($this->name, "/");
    }
}