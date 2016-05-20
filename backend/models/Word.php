<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dictionary".
 *
 * @property integer $id
 * @property string $identifier
 * @property string $last_edit
 * @property integer $last_edit_user
 *
 * @property User $lastEditUser
 * @property WordTranslation[] $dictionaryTranslations
 * @property Language[] $languages
 */
class Word extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'word';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['identifier'], 'required'],
            [['last_edit'], 'safe'],
            [['last_edit_user'], 'integer'],
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
            'identifier' => 'Identifikátor',
            'last_edit' => 'Posledná úprava',
            'last_edit_user' => 'Posledne upravil',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictionaryTranslations()
    {
        return $this->hasMany(WordTranslation::className(), ['word_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Language::className(), ['id' => 'language_id'])->viaTable('dictionary_translation', ['word_id' => 'id']);
    }
}
