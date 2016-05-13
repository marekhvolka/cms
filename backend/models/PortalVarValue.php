<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "portal_var_value".
 *
 * @property integer $id
 * @property integer $portal_id
 * @property integer $variable_id
 * @property string $value
 * @property int $value_page_id
 *
 * @property Page $page
 * @property Portal $portal
 */
class PortalVarValue extends \yii\db\ActiveRecord
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
            [['value'], 'string'],
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
            'value' => 'Value',
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
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'value_page_id']);
    }
}
