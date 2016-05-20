<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dictionary_translation".
 *
 * @property integer $id
 * @property integer $word_id
 * @property string $translation
 * @property integer $language_id
 *
 * @property Word $word
 * @property Language $language
 */
class WordTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'word_translation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['word_id', 'translation', 'language_id'], 'required'],
            [['word_id', 'language_id'], 'integer'],
            [['translation'], 'string', 'max' => 255],
            [['word_id', 'language_id'], 'unique', 'targetAttribute' => ['word_id', 'language_id'], 'message' => 'The combination of Word ID and Language ID has already been taken.'],
            [['word_id'], 'exist', 'skipOnError' => true, 'targetClass' => Word::className(), 'targetAttribute' =>
                ['word_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'word_id'     => 'Word ID',
            'translation' => 'Translation',
            'language_id' => 'Language ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWord()
    {
        return $this->hasOne(Word::className(), ['id' => 'word_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }
}
