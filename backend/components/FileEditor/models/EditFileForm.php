<?php

namespace backend\components\FileEditor\models;

use backend\components\PathHelper;
use yii\base\Model;

/**
 * Used to edit a file.
 *
 * @package common\widgets\FileEditor\models
 */
class EditFileForm extends Model
{
    /**
     * The new content of the file.
     *
     * @var string
     */
    public $text;

    /**
     * The name + path to the file to be edited.
     *
     * @var string
     */
    public $fileName;

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
        $this->baseDir = $baseDir;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['fileName', 'required'],
            ['text', 'safe'],
            ['fileName', function ($attribute) {
                if (!PathHelper::isInside(realpath($this->baseDir . $this->fileName), realpath($this->baseDir))) {
                    $this->addError($attribute, 'Invalid directory.');
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
            file_put_contents($this->baseDir . $this->fileName, $this->text);
        }
    }

    /**
     * Return the full path to the file.
     *
     *  @return string the path
     */
    public function getFullPath()
    {
        return $this->baseDir . $this->fileName;
    }
}