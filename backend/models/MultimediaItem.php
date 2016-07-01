<?php

namespace backend\models;

use backend\components\PathHelper;
use Yii;
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
            [['file'], 'file', 'skipOnEmpty' => false]
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['name'],
            self::SCENARIO_UPLOAD => ['file']
        ];
    }

    /**
     * Upload the new file, so that the new multimedia item gets saved.
     *
     * @return bool the successfulness of the operation
     */
    public function upload($path)
    {
        if ($this->validate(['file'])) {
            PathHelper::makePath($path);

            $this->name = $this->file->getBaseName() . '.' . $this->file->getExtension();
            return $this->file->saveAs($path . DIRECTORY_SEPARATOR . $this->file->getBaseName() . '.' . $this->file->getExtension());
        }

        return false;
    }

    /**
     * Delete the item.
     */
    public function delete($fromPath)
    {
        $path = $fromPath . DIRECTORY_SEPARATOR . $this->name;

        if (is_file($path)) {
            PathHelper::remove($path);
        }
    }
}