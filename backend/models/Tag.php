<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 * @property string $nazov_system
 * @property string $identifier
 * @property integer $active
 * @property string $product_type
 * @property string $last_edit
 * @property integer $last_edit_user
 *
 * @property Tag[] $products
 * @property User $lastEditUser
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    public function init()
    {
        $this->active = 1;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'nazov_system', 'identifier', 'active', 'product_type'], 'required'],
            [['active', 'last_edit_user'], 'integer'],
            [['last_edit'], 'safe'],
            [['name', 'nazov_system', 'identifier'], 'string', 'max' => 50],
            [['product_type'], 'string', 'max' => 100],
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
            'name' => 'Name',
            'nazov_system' => 'Nazov System',
            'identifier' => 'Identifikator',
            'active' => 'Active',
            'product_type' => 'Product Type',
            'last_edit' => 'Last Edit',
            'last_edit_user' => 'Last Edit User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        //TODO: fix
        return $this->hasMany(Product::className(), ['tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastEditUser()
    {
        return $this->hasOne(User::className(), ['id' => 'last_edit_user']);
    }
}
