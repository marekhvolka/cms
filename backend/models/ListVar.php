<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "list".
 *
 * @property integer $id
 *
 * @property ListItem[] $listItems
 * @property SnippetVarValue[] $snippetVarValues
 */
class ListVar extends \yii\db\ActiveRecord
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListItems()
    {
        return $this->hasMany(ListItem::className(), ['list_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetVarValues()
    {
        return $this->hasMany(SnippetVarValue::className(), ['value_list_id' => 'id']);
    }

    public function getValue()
    {
        $buffer = 'array(';

        foreach($this->listItems as $listItem)
        {
            if ($listItem->active)
            {
                $buffer .= '\'' . $listItem->id . '\' => ' . $listItem->value . ', ';
            }
        }

        $buffer .= ')';

        return $buffer;
    }
}
