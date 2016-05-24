<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_var_value".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $var_id
 * @property string $value
 *
 * @property Product $product
 * @property ProductVar $var
 */
class ProductVarValue extends \yii\db\ActiveRecord
{
    public $existing;
    
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
            [['var_id'], 'required'],
            [['product_id', 'var_id'], 'integer'],
            [['value'], 'string'],
            [['var_id', 'product_id'], 'unique', 'targetAttribute' => ['var_id', 'product_id'], 'message' => 'The combination of Product ID and Var ID has already been taken.']
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
            'var_id' => 'Var ID',
            'value' => 'Value',
        ];
    }

    
    public function getExisting()
    {
        return $this->existing;
    }
     
    public function setExisting($newExisting)
    {
        $this->existing = $newExisting;
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
    public function getVar()
    {
        return $this->hasOne(ProductVar::className(), ['id' => 'var_id']);
    }
    
}
