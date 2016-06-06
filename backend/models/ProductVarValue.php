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
 * @property int $value_block_id
 *
 * @property Block $valueBlock
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
            'product_id' => 'Product ID',
            'portal_id' => 'Portal ID',
            'var_id' => 'Var ID',
            'value_text' => 'Value',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueBlock()
    {
        return $this->hasOne(Block::className(), ['id' => 'value_block_id']);
    }

    /** Vrati hodnotu premennej - determinuje, z ktoreho stlpca ju ma tahat
     * @return mixed|string
     */
    public function getValue()
    {
        $value = null;

        switch ($this->var->type->identifier)
        {
            case 'list' :

                $value = $this->valueListVar->value;

                break;

            case 'page' :

                if (isset($this->valuePage))
                    $value = '$portal->pages->page' . $this->valuePage->id;
                else
                    $value = 'NULL';

                break;

            case 'product' :
                if (isset($this->valueProduct))
                    $value = '$' . $this->valueProduct->identifier;
                else
                    $value = 'NULL';

                break;

            case 'product_snippet' :

                $value = $this->valueBlock->compileBlock();
                break;
            default:

                $value = '\''. addslashes(html_entity_decode(Yii::$app->cacheEngine->normalizeString(($this->value_text)))) . '\'';
        }

        return $value;
    }
    
}
