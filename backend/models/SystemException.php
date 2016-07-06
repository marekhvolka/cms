<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "system_exception".
 *
 * @property integer $identifier
 * @property string $time
 * @property string $message
 */
class SystemException extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'system_exception';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time'], 'safe'],
            [['message'], 'required'],
            [['message'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'identifier' => 'Identifikátor',
            'time' => 'Čas',
            'message' => 'Správa',
        ];
    }
}
