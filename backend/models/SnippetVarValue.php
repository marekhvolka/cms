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
class SnippetVarValue extends VariableValue implements IDuplicable
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
                    'list_item_id',
                    'value_dropdown_id'
                ],
                'integer'
            ],
            [['value_text'], 'string'],
            [
                ['var_id', 'block_id', 'list_item_id'],
                'unique',
                'targetAttribute' => ['var_id', 'block_id', 'list_item_id'],
                'message' => 'The combination of Block ID, ListItemID and Var ID has already been taken.'
            ],
            [
                'block_id',
                'atLeastOne',
                'params' => [
                    'list_item_id',
                ]
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

    public function resetAfterUpdate()
    {
        if ($this->block) {
            $this->block->resetAfterUpdate();
        } else if ($this->listItem) {
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

        foreach ($this->listItems as $listItem) {
            if ($listItem->isChanged()) {
                return true;
            }
        }
        return false;
    }
}
