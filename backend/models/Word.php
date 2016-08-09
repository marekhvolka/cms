<?php

namespace backend\models;

use common\models\User;
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
 * @property WordTranslation[] $translations
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
    public function getTranslations()
    {
        if (!isset($this->translations)) {
            $this->translations = array();

            foreach (Language::find()->all() as $language) {
                $wordTranslation = WordTranslation::find()->where([
                    'word_id' => $this->id,
                    'language_id' => $language->id
                ])->one();

                if ($wordTranslation) {
                    $this->translations[] = $wordTranslation;
                } else {
                    $wordTranslation = new WordTranslation();
                    $wordTranslation->language_id = $language->id;

                    $this->translations[] = $wordTranslation;
                }
            }
        }

        return $this->translations;
    }

    public function setTranslations($value) { $this->translations = $value; }

    public function resetAfterUpdate()
    {
        /* @var $language Language */
        foreach(Language::find()->all() as $language) {
            $language->getDictionaryCacheFile(true);
        }
    }
}
