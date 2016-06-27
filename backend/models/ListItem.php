<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "list_item".
 *
 * @property integer $id
 * @property integer $list_id
 * @property integer $active
 *
 * @property SnippetVarValue[] $snippetVarValues
 * @property ListVar $list
 */
class ListItem extends CustomModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'list_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['list_id'], 'required'],
            [['id', 'list_id', 'active'], 'integer'],
            [
                ['list_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ListVar::className(),
                'targetAttribute' => ['list_id' => 'id']
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
            'list_id' => 'List ID',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getList()
    {
        return $this->hasOne(ListVar::className(), ['id' => 'list_id']);
    }

    public function getSnippetVarValues()
    {
        if (!isset($this->snippetVarValues)) {
            $this->snippetVarValues = $this->hasMany(SnippetVarValue::className(), ['list_item_id' => 'id'])->all();
        }
        return $this->snippetVarValues;
    }

    public function setSnippetVarValues($value)
    {
        $this->snippetVarValues = $value;
    }

    public function getValue($productType = null)
    {
        $buffer = '(object) array(' . PHP_EOL;

        foreach ($this->snippetVarValues as $snippetVarValue) {
            $buffer .= '\'' . $snippetVarValue->var->identifier . '\' => ' . $snippetVarValue->getValue($productType) . ', ';
        }

        $buffer = substr($buffer, 0, sizeof($buffer) - 2);

        $buffer .= ')';

        return $buffer;
    }

    public function resetAfterUpdate()
    {
        $this->list->resetAfterUpdate();
    }
}
