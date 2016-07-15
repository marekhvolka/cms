<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_var_value".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $var_id
 * @property string $value_text
 *
 * @property string $value
 * @property Block $valueBlock
 * @property Product $product
 * @property ProductVar $var
 */
class ProductVarValue extends Variable implements IDuplicable
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
            [['var_id'], 'required'],
            [['product_id', 'var_id'], 'integer'],
            [['value_text'], 'string'],
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
            'product_id' => 'ID produktu',
            'portal_id' => 'ID portálu',
            'var_id' => 'ID premennej',
            'value_text' => 'Hodnota',
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
    public function getVar()
    {
        return $this->hasOne(ProductVar::className(), ['id' => 'var_id']);
    }

    public function getValueBlock()
    {
        if (!isset($this->valueBlock)) {
            $this->valueBlock = $this->hasOne(Block::className(), ['product_var_value_id' => 'id']);
        }

        return $this->valueBlock;
    }

    public function setValueBlock($value)
    {
        $this->valueBlock = $value;
    }

    public function prepareToDuplicate()
    {
        if ($this->valueBlock) {
            $this->valueBlock->prepareToDuplicate();
        }

        unset($this->id);
    }
}
