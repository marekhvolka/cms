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
     * Event fired before save model. User id is set as last user who edits model.
     * @param bool $insert true if save is insert type, false if update.
     * @return bool
     */
    public function beforeSave($insert)
    {
        $userId = Yii::$app->user->identity->id;
        $this->last_edit_user = $userId;

        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(WordTranslation::className(), ['word_id' => 'id']);
    }
}
