<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "snippet_var_default_value".
 *
 * @property integer $id
 * @property integer $snippet_var_id
 * @property integer $product_type_id
 * @property integer $partnership_type_id
 * @property string $value_text
 * @property integer $value_dropdown_id
 *
 * @property SnippetVarDropdown $valueDropdown
 * @property ProductType $productType
 * @property PartnershipType $partnershipType
 * @property SnippetVar $snippetVar
 */
class SnippetVarDefaultValue extends CustomModel
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
            [['snippet_var_id', 'product_type_id', 'partnership_type_id'], 'integer'],
            [['value_text'], 'string', 'max' => 255],
            [
                ['snippet_var_id', 'product_type_id', 'partnership_type_id'],
                'unique',
                'targetAttribute' => ['snippet_var_id', 'product_type_id', 'partnership_type_id'],
                'message' => 'Pre danú premennú už existuje kombinácia typu produktu a typu spolupráce.'
            ],
            [
                ['product_type_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ProductType::className(),
                'targetAttribute' => ['product_type_id' => 'id']
            ],
            [
                ['snippet_var_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => SnippetVar::className(),
                'targetAttribute' => ['snippet_var_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'snippet_var_id' => 'Snippet Var ID premennej snippetu',
            'product_type_id' => 'ID typu produktu',
            'value_text' => 'Predvolená hodnota',
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
    public function getPartnershipType()
    {
        return $this->hasOne(PartnershipType::className(), ['id' => 'partnership_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetVar()
    {
        return $this->hasOne(SnippetVar::className(), ['id' => 'snippet_var_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueDropdown()
    {
        return $this->hasOne(SnippetVarDropdown::className(), ['id' => 'value_dropdown_id']);
    }

    public function getValue()
    {
        return $this->valueDropdown == null ? '' : $this->valueDropdown->value;
    }
}
