<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "portal_var_value".
 *
 * @property integer $id
 * @property integer $portal_id
 * @property integer $variable_id
 * @property string $value_text
 * @property int $value_page_id
 *
 * @property Block $valueBlock
 * @property Page $valuePage
 * @property Portal $portal
 */
class PortalVarValue extends VariableValue
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'portal_var_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['var_id'], 'required'],
            [['portal_id', 'var_id', 'value_page_id'], 'integer'],
            [['value_text'], 'string'],
            [['var_id', 'portal_id'], 'unique', 'targetAttribute' => ['var_id', 'portal_id'], 'message' => 'The combination of Portal ID and Var ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'portal_id' => 'ID portálu',
            'var_id' => 'ID premennej',
            'value_text' => 'Hodnota',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortal()
    {
        return $this->hasOne(Portal::className(), ['id' => 'portal_id']);
    }

    public function getValueBlock()
    {
        if (!isset($this->valueBlock)) {
            $this->valueBlock = $this->hasOne(Block::className(), ['portal_var_value_id' => 'id'])->one();
        }

        return $this->valueBlock;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVar()
    {
        return $this->hasOne(PortalVar::className(), ['id' => 'var_id']);
    }
}
