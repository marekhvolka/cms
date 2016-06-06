<?php

namespace backend\components\FileEditor\models;


use yii\base\Model;

class EditFileForm extends Model
{
    public $text;
    public $fileName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['fileName', 'required'],
            ['text', 'safe']
        ];
    }
}