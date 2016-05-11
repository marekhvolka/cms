<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "variable_value".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $portal_id
 * @property integer $variable_id
 * @property string $value
 *
 * @property Product $product
 * @property Variable $variable
 */
class VariableValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'variable_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['variable_id'], 'required'],
            [['product_id', 'portal_id', 'variable_id'], 'integer'],
            [['value'], 'string'],
            [['variable_id', 'product_id'], 'unique', 'targetAttribute' => ['variable_id', 'product_id'], 'message' => 'The combination of Product ID and Var ID has already been taken.']
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
            'portal_id' => 'Portal ID',
            'variable_id' => 'Var ID',
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
    public function getPortal()
    {
        return $this->hasOne(Portal::className(), ['id' => 'portal_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippet()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariable()
    {
        return $this->hasOne(Variable::className(), ['id' => 'variable_id']);
    }
}
