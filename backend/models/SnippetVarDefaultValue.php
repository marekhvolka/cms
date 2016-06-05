<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "snippet_var_default_value".
 *
 * @property integer $id
 * @property integer $snippet_var_id
 * @property integer $product_type_id
 * @property string $value
 *
 * @property ProductType $productType
 * @property SnippetVar $snippetVar
 */
class SnippetVarDefaultValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'snippet_var_default_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['snippet_var_id'], 'required'],
            [['snippet_var_id', 'product_type_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['snippet_var_id', 'product_type_id'], 'unique', 'targetAttribute' => ['snippet_var_id', 'product_type_id'], 'message' => 'The combination of Snippet Var ID and Product Type ID has already been taken.'],
            [['product_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductType::className(), 'targetAttribute' => ['product_type_id' => 'id']],
            [['snippet_var_id'], 'exist', 'skipOnError' => true, 'targetClass' => SnippetVar::className(), 'targetAttribute' => ['snippet_var_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'snippet_var_id' => 'Snippet Var ID',
            'product_type_id' => 'Product Type ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductType()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'product_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetVar()
    {
        return $this->hasOne(SnippetVar::className(), ['id' => 'snippet_var_id']);
    }
}
