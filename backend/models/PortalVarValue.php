<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "portal_var_value".
 *
 * @property integer $id
 * @property integer $portal_id
 * @property integer $var_id
 * @property string $value
 *
 * @property Portal $portal
 * @property PortalVar $attr
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
            [['portal_id', 'var_id'], 'required'],
            [['portal_id', 'var_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['portal_id', 'var_id'], 'unique', 'targetAttribute' => ['portal_id', 'var_id'], 'message' => 'The combination of Portal ID and Attr ID has already been taken.']
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
    public function getAttr()
    {
        return $this->hasOne(PortalVar::className(), ['id' => 'var_id']);
    }
}
