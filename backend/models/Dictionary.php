<?php

namespace backend\models;


use common\models\User;
use Yii;
use yii\db\ActiveRecord;

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
class Dictionary extends ActiveRecord
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
        //return $this->hasMany('DictionaryTranslation', array('post_id' => 'id'));
        //return $this->hasMany(DictionaryTranslation::className(), ['word_id' => 'id']);
        return Yii::$app->db->createCommand('SELECT * FROM dictionary_translation WHERE word_id = ' . $this->id)
            ->queryAll();
    }
}
