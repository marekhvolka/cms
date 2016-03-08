<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "portal_var".
 *
 * @property integer $id
 * @property string $vlastnost
 * @property string $identifikator
 * @property string $popis
 * @property integer $type_id
 * @property string $last_edit
 * @property integer $last_edit_user
 *
 * @property User $lastEditUser
 * @property VarType $type
 * @property PortalVarValue[] $portalVarValues
 */
class PortalVar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'portal_var';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vlastnost', 'identifikator', 'type_id'], 'required'],
            [['popis'], 'string'],
            [['type_id', 'last_edit_user'], 'integer'],
            [['last_edit'], 'safe'],
            [['vlastnost'], 'string', 'max' => 50],
            [['identifikator'], 'string', 'max' => 30],
            [['identifikator'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vlastnost' => 'Vlastnost',
            'identifikator' => 'Identifikator',
            'popis' => 'Popis',
            'type_id' => 'Type ID',
            'last_edit' => 'Last Edit',
            'last_edit_user' => 'Last Edit User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastEditUser()
    {
        return $this->hasOne(User::className(), ['id' => 'last_edit_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(VarType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortalVarValues()
    {
        return $this->hasMany(PortalVarValue::className(), ['attr_id' => 'id']);
    }
}
