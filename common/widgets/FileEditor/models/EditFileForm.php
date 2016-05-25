<?php
/**
 * Created by PhpStorm.
 * User: juraj
 * Date: 24/05/16
 * Time: 19:17
 */

namespace common\widgets\FileEditor\models;


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