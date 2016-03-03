<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dictionary".
 *
 * @property integer $id
 * @property string $word
 * @property string $identifier
 * @property string $last_edit
 * @property integer $last_edit_user
 *
 * @property User $lastEditUser
 * @property DictionaryTranslation[] $dictionaryTranslations
 */
class Dictionary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dictionary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['word', 'identifier'], 'required'],
            [['last_edit'], 'safe'],
            [['last_edit_user'], 'integer'],
            [['word'], 'string', 'max' => 255],
            [['identifier'], 'string', 'max' => 200],
            [['identifier'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'word' => 'Word',
            'identifier' => 'Identifier',
            'last_edit' => 'Last Edit',
            'last_edit_user' => 'Last Edit User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastEditUser()
    {
        return $this->hasOne(User::className(), ['id' => 'last_edit_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictionaryTranslations()
    {
        return $this->hasMany(DictionaryTranslation::className(), ['word_id' => 'id']);
    }
}
