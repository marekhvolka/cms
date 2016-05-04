<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "portal_var".
 *
 * @property integer $id
 * @property string $name
 * @property string $identifier
 * @property string $description
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
            [['name', 'identifier', 'type_id'], 'required'],
            [['description'], 'string'],
            [['type_id', 'last_edit_user'], 'integer'],
            [['last_edit'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['identifier'], 'string', 'max' => 30],
            [['identifier'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Názov',
            'identifier' => 'Identifikator',
            'description' => 'Popis',
            'type_id' => 'Type ID',
            'last_edit' => 'Last Edit',
            'last_edit_user' => 'Naposledy editoval',
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
        return $this->hasMany(PortalVarValue::className(), ['var_id' => 'id']);
    }
}
