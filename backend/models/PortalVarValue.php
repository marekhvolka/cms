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
class PortalVarValue extends CustomModel
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
            'portal_id' => 'Portal ID',
            'var_id' => 'Var ID',
            'value_text' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortal()
    {
        return $this->hasOne(Portal::className(), ['id' => 'portal_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVar()
    {
        return $this->hasOne(PortalVar::className(), ['id' => 'var_id']);
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
    public function getValueBlock()
    {
        return $this->hasOne(Block::className(), ['portal_var_value_id' => 'id']);
    }

    public function getValue()
    {
        $value = '';

        switch ($this->var->type->identifier)
        {
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

            case 'portal_snippet' :

                $value = $this->valueBlock->compileBlock();

                break;
            default:
                $value = '\''. addslashes($this->value_text) . '\'';
        }

        return $value;
    }
}
