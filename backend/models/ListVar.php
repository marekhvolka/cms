<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "list".
 *
 * @property integer $id
 * @property integer $snippet_var_value_id
 *
 * @property string $value
 * @property ListItem[] $listItems
 * @property SnippetVarValue $snippetVarValue
 */
class ListVar extends CustomModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'snippet_var_value_id' => 'Snippet Var Value ID'
        ];
    }

    public function createNewListItem()
    {
        $listItem = new ListItem();
        $listItem->active = true;
        $listItem->getSnippetVarValues();

        foreach ($this->snippetVarValue->var->children as $childVar) {
            $childVarValue = new SnippetVarValue();
            $childVarValue->var_id = $childVar->id;

            if ($childVar->isSnippet()) {
                $childVarValue->valueListVar = new ListVar();
            }

            $listItem->snippetVarValues[] = $childVarValue;
        }

        return $listItem;
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetVarValue()
    {
        return $this->hasOne(SnippetVarValue::className(), ['id' => 'snippet_var_value_id']);
    }

    public function getValue($productType = null)
    {
        $buffer = ' array(' . PHP_EOL;

        $index = 0;
        foreach ($this->listItems as $listItem) {
            if ($listItem->active) {
                $buffer .= '\'' . $index++ . '\' => ' . $listItem->getValue($productType) . ', ' . PHP_EOL;
            }
        }

        $buffer .= ')';

        return $buffer;
    }

    public function resetAfterUpdate()
    {
        if ($this->snippetVarValue) {
            $this->snippetVarValue->resetAfterUpdate();
        }
    }
}
