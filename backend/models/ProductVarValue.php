<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_var_value".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $attr_id
 * @property string $value
 *
 * @property Product $product
 * @property ProductVar $attr
 */
class ProductVarValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_var_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attr_id'], 'required'],
            [['product_id', 'attr_id'], 'integer'],
            [['value'], 'string'],
            [['attr_id', 'product_id'], 'unique', 'targetAttribute' => ['attr_id', 'product_id'], 'message' => 'The combination of Product ID and Attr ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'attr_id' => 'Attr ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttr()
    {
        return $this->hasOne(ProductVar::className(), ['id' => 'attr_id']);
    }
}
