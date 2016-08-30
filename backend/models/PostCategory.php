<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "post_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $identifier
 */
class PostCategory extends CustomModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'identifier'], 'required'],
            [['name', 'identifier'], 'string', 'max' => 45],
            [['name'], 'unique'],
            [['identifier'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Názov',
            'identifier' => 'Identifikátor',
        ];
    }
}
