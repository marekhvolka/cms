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
 * @property int $value_dropdown_id
 * @property int $list_item_id
 *
 * @property string $value
 * @property SnippetVarDropdown $valueDropdown
 * @property ListItem[] $listItems
 * @property ListItem $listItem
 * @property Product $valueProduct
 * @property Tag $valueTag
 * @property ProductVar $valueProductVar
 * @property Page $valuePage
 * @property Block $block
 * @property SnippetVar $var
 */
class SnippetVarValue extends CustomModel implements IDuplicable
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
            [
                [
                    'block_id',
                    'var_id',
                    'value_page_id',
                    'value_tag_id',
                    'value_product_var_id',
                    'value_product_id',
                    'list_item_id'
                ],
                'integer'
            ],
            [['value_text'], 'string'],
            [
                ['var_id', 'block_id', 'list_item_id'],
                'unique',
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
            'block_id' => 'ID bloku',
            'var_id' => 'ID premennej',
            'value' => 'Hodnota',
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

    public function getListItem()
    {
        return $this->hasOne(ListItem::className(), ['id' => 'list_item_id']);
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
    public function getValueProductVar()
    {
        return $this->hasOne(ProductVar::className(), ['id' => 'value_product_var_id']);
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
    public function getListItems()
    {
        if (!isset($this->listItems)) {
            $this->listItems = $this->hasMany(ListItem::className(), ['list_id' => 'id'])
                ->orderBy(['order' => SORT_ASC])
                ->all();
        }

        return $this->listItems;
    }

    public function setListItems($value)
    {
        $this->listItems = $value;
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

                $value = 'array(';
                $index = 0;

                foreach ($this->listItems as $listItem) {
                    if ($listItem->active) {
                        $value .= '\'' . $index++ . '\' => ' . $listItem->getValue($productType) . ', ' . PHP_EOL;
                    }
                }

                $value .= ')';

                break;

            case 'bool' :
                $value = $this->value_text == 1 ? 'true' : 'false';

                break;
            case 'page' :

                if (isset($this->valuePage)) {
                    $value = '$portal->pages->page' . $this->valuePage->id;
                } else {
                    $value = 'NULL';
                }

                break;

            case 'product' :
                if (isset($this->valueProduct)) {
                    $value = '$' . $this->valueProduct->identifier;
                } else {
                    $value = 'NULL';
                }

                break;
            case 'product_var' :
                if (isset($this->valueProductVar)) {
                    $value = '\'' . $this->valueProductVar->identifier . '\'';
                } else {
                    $value = 'NULL';
                }
                break;
            case 'product_tag' :

                if ($this->valueTag) {
                    $value = '$tags->' . $this->valueTag->identifier;
                } else {
                    $value = 'NULL';
                }

                break;
            case 'dropdown' :

                if (!isset($this->valueDropdown)) {
                    $this->value_dropdown_id = $this->var->defaultValue->valueDropdown->id;
                    $this->save();

                    $value = '\'' . $this->var->defaultValue->valueDropdown->value . '\'';
                } else {
                    $value = '\'' . $this->valueDropdown->value . '\'';
                }

                break;
            default:

                if (isset($this->value_text) && $this->value_text != '') {
                    $value = '\'' . html_entity_decode(Yii::$app->dataEngine->normalizeString(($this->value_text))) . '\'';
                } else {
                    $defaultValue = $this->var->getDefaultValue($productType);

                    if (isset($defaultValue)) {
                        $value = '\'' . html_entity_decode(Yii::$app->dataEngine->normalizeString(($defaultValue->value))) . '\'';
                    } else {
                        $value = '\'\'';
                    }
                }
        }

        return $value;
    }

    /** Getter for $typeName property
     * @return string
     */
    public function getTypeName()
    {
        return $this->var->type->identifier;
    }

    public function resetAfterUpdate()
    {
        if ($this->block) {
            $this->block->resetAfterUpdate();
        }
        else if ($this->listItem) {
            $this->listItem->resetAfterUpdate();
        }
    }

    public function prepareToDuplicate()
    {
        foreach ($this->listItems as $listItem) {
            $listItem->prepareToDuplicate();
        }

        unset($this->id);
        $this->block_id = null;
    }

    public function isChanged()
    {
        if (parent::isChanged())
            return true;

        foreach($this->listItems as $listItem) {
            if ($listItem->isChanged()) {
                return true;
            }
        }
        return false;
    }
}
