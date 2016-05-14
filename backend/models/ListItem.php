<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "list_item".
 *
 * @property integer $id
 * @property integer $list_id
 * @property integer $active
 *
 * @property ListVar $list
 */
class ListItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'list_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['list_id'], 'required'],
            [['id', 'list_id', 'active'], 'integer'],
            [['list_id'], 'exist', 'skipOnError' => true, 'targetClass' => ListVar::className(), 'targetAttribute' => ['list_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'list_id' => 'List ID',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getList()
    {
        return $this->hasOne(ListVar::className(), ['id' => 'list_id']);
    }
}