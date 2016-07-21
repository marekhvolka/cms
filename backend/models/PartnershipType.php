<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "partnership_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $identifier
 *
 * @property Product[] $products
 */
class PartnershipType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partnership_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'identifier'], 'string', 'max' => 50],
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
            'identifier' => 'Identifikátor'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['partnership_type_id' => 'id']);
    }
}
