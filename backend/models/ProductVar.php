<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "product_var".
 *
 * @property integer $id
 * @property string $name
 * @property string $identifier
 * @property string $popis
 * @property integer $type_id
 * @property string $product_type
 * @property string $last_edit
 * @property integer $last_edit_user
 *
 * @property User $lastEditUser
 * @property VarType $type
 * @property ProductVarValue[] $productVarValues
 */
class ProductVar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_var';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'identifier', 'type_id', 'product_type'], 'required'],
            [['type_id', 'last_edit_user'], 'integer'],
            [['last_edit'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['identifier'], 'string', 'max' => 30],
            [['product_type'], 'string', 'max' => 80],
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
            'identifier' => 'Identifikátor',
            'popis' => 'Popis',
            'type_id' => 'Var Type',
            'product_type' => 'For Product Types',
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
    public function getProductVarValues()
    {
        return $this->hasMany(ProductVarValue::className(), ['var_id' => 'id']);
    }
}
