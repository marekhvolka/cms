<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "snippet_var_value".
 *
 * @property integer $id
 * @property integer $var_id
 * @property string $value_text
 * @property int $value_page_id
 * @property int $value_product_id
 * @property int $value_tag_id
 * @property int $value_product_var_id
 * @property int $block_id
 * @property int $value_list_id
 * @property int $value_dropdown_id
 * @property int $list_item_id
 *
 * @property string $value
 * @property SnippetVarDropdown $valueDropdown
 * @property ListVar $valueListVar
 * @property Product $valueProduct
 * @property Page $valuePage
 * @property Block $block
 * @property SnippetVar $var
 */
class SnippetVarValue extends CustomModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'snippet_var_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['var_id'], 'required'],
            [['block_id', 'var_id', 'value_page_id', 'value_tag_id',
            'value_product_var_id', 'value_product_id', 'list_item_id'], 'integer'],
            [['value_text'], 'string'],
            [
                ['var_id', 'block_id', 'list_item_id'], 'unique',
                'targetAttribute' => ['var_id', 'block_id', 'list_item_id'],
                'message' => 'The combination of Block ID, ListItemID and Var ID has already been taken.'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'block_id' => 'Block ID',
            'var_id' => 'Var ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlock()
    {
        return $this->hasOne(Block::className(), ['id' => 'block_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVar()
    {
        return $this->hasOne(SnippetVar::className(), ['id' => 'var_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValuePage()
    {
        return $this->hasOne(Page::className(), ['id' => 'value_page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'value_tag_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueDropdown()
    {
        return $this->hasOne(SnippetVarDropdown::className(), ['id' => 'value_dropdown_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'value_product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueListVar()
    {
        return $this->hasOne(ListVar::className(), ['snippet_var_value_id' => 'id']);
    }

    /** Vrati hodnotu premennej - determinuje, z ktoreho stlpca ju ma tahat
     * @param null $productType
     * @return mixed|string
     */
    public function getValue($productType = null)
    {
        $value = null;

        switch ($this->var->type->identifier) {
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

            case 'product_tag' :

                $value = '$' . $this->valueTag->identifier;

                //TODO: dokoncit
                break;
            case 'dropdown' :

                $value = '\'' . $this->valueDropdown->value . '\'';

                break;
            default:

                if (isset($this->value_text) && $this->value_text != '')
                    $value = '\''. html_entity_decode(Yii::$app->cacheEngine->normalizeString(($this->value_text))) . '\'';
                else
                {
                    $value = '\''. html_entity_decode(Yii::$app->cacheEngine->normalizeString(($this->getDefaultValue($productType)))) . '\'';
                }
        }

        return $value;
    }

    /** Vrati default hodnotu podla typu produktu
     * @param $productType
     * @return mixed|string
     */
    public function getDefaultValue($productType = null)
    {
        if ($productType) {
            $defaultValue = SnippetVarDefaultValue::find()
                    ->andWhere([
                        'snippet_var_id' => $this->var->id,
                        'product_type_id' => $productType->id
                    ])
                    ->one();
        }
        if (!isset($defaultValue)) {
            $defaultValue = SnippetVarDefaultValue::find()
                    ->andWhere([
                        'snippet_var_id' => $this->var->id,
                        'product_type_id' => null
                    ])
                    ->one();
        }

        if ($defaultValue != NULL)
            return Yii::$app->cacheEngine->normalizeString($defaultValue->value);

        return null;
    }

    /** Getter for $typeName property
     * @return string
     */
    public function getTypeName()
    {
        return $this->var->type->identifier;
    }

}
