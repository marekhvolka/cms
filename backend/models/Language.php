<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "language".
 *
 * @property integer $id
 * @property string $name
 * @property string $currency
 * @property string $identifier
 * @property integer $active
 *
 * @property DictionaryTranslation[] $dictionaryTranslations
 * @property Portal[] $portals
 * @property Product[] $products
 */
class Language extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'language';
    }

        public function init()
    {
        $this->active = 1;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'currency', 'identifier', 'active'], 'required'],
            [['active'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['currency'], 'string', 'max' => 5],
            [['identifier'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'currency' => 'Currency',
            'identifier' => 'Identifier',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictionaryTranslations()
    {
        return $this->hasMany(DictionaryTranslation::className(), ['lng' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortals()
    {
        return $this->hasMany(Portal::className(), ['language_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['language_id' => 'id']);
    }
}
