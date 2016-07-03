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
 * @property SnippetVarValue $list
 */
class ListItem extends CustomModel implements IDuplicable
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
            [['list_id', 'order'], 'required'],
            [['id', 'list_id', 'active'], 'integer'],
            [
                ['list_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => SnippetVarValue::className(),
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
        return $this->hasOne(SnippetVarValue::className(), ['id' => 'list_id']);
    }

    public function getSnippetVarValues()
    {
        if (!isset($this->snippetVarValues)) {
            foreach($this->list->var->children as $snippetVar) {
                $snippetVarValue = SnippetVarValue::find()->where([
                    'list_item_id' => $this->id,
                    'var_id' => $snippetVar->id
                ])->one();

                if ($snippetVarValue)
                    $this->snippetVarValues[] = $snippetVarValue;
                else {
                    $snippetVarValue = new SnippetVarValue();
                    $snippetVarValue->var_id = $snippetVar->id;

                    $this->snippetVarValues[] = $snippetVarValue;
                }
            }
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

    public function prepareToDuplicate()
    {
        foreach($this->snippetVarValues as $snippetVarValue) {
            $snippetVarValue->prepareToDuplicate();
        }

        $this->id = null;
        $this->list_id = null;
    }
}
