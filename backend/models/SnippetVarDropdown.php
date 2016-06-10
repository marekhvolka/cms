<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "snippet_var_dropdown".
 *
 * @property integer $id
 * @property integer $var_id
 * @property string $value
 *
 * @property SnippetVarDefaultValue[] $snippetVarDefaultValues
 * @property SnippetVar $var
 */
class SnippetVarDropdown extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'snippet_var_dropdown';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['var_id', 'value'], 'required'],
            [['var_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['var_id', 'value'], 'unique', 'targetAttribute' => ['var_id', 'value'], 'message' => 'The combination of Var ID and Value has already been taken.'],
            [['var_id'], 'exist', 'skipOnError' => true, 'targetClass' => SnippetVar::className(), 'targetAttribute' => ['var_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'var_id' => 'Var ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippetVarDefaultValues()
    {
        return $this->hasMany(SnippetVarDefaultValue::className(), ['value_dropdown_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVar()
    {
        return $this->hasOne(SnippetVar::className(), ['id' => 'var_id']);
    }
}
